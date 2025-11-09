<?php

namespace App\Services;

use App\Repositories\ActivityRepository;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityMedia;
use App\Services\FileStorageService;

class ActivityService
{
    protected ActivityRepository $activities;
    protected FileStorageService $storageService;

    public function __construct(ActivityRepository $activities, FileStorageService $storageService)
    {
        $this->activities = $activities;
        $this->storageService = $storageService;
    }

    public function all(array $with = [])
    {
        return $this->activities->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->activities->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->activities->findOrFail($id, $with);
    }

    /**
     * Create activity with optional media files transactionally.
     * Stores files to the public disk first, then creates DB records inside a transaction.
     * On failure, uploaded files are cleaned up.
     *
     * @param array $attributes
     */
    public function create(array $attributes)
    {
        $mediaFiles = $attributes['media'] ?? [];
        unset($attributes['media']);

        $storedPaths = [];
        try {
            // store uploaded files first
            if (!empty($mediaFiles)) {
                $storedPaths = $this->storageService->storeFiles($mediaFiles, $this->activities->getTable());
            }

            // Transactional DB work
            DB::beginTransaction();

            $activity = $this->activities->create($attributes);

            if (!empty($storedPaths)) {
                $rows = array_map(fn($p) => ['file_url' => $p], $storedPaths);
                $activity->media()->createMany($rows);
            }

            DB::commit();

            return $activity;
        } catch (\Throwable $e) {
            DB::rollBack();
            // cleanup uploaded files on failure
            foreach ($storedPaths as $p) {
                try { Storage::disk('public')->delete($p); } catch (\Throwable $_) {}
            }
            throw $e;
        }
    }

    /**
     * Update activity and sync media transactionally.
     * Supports adding new files (media) and removing existing media via removed_media_ids.
     *
     * @param mixed $id
     * @param array $attributes
     */
    public function update($id, array $attributes)
    {
        $newMedia = $attributes['media'] ?? [];
        unset($attributes['media']);

        $removedIds = $attributes['removed_media_ids'] ?? [];
        unset($attributes['removed_media_ids']);

        $storedPaths = [];
        // store new files first
        try {
            if (!empty($newMedia)) {
                $storedPaths = $this->storageService->storeFiles($newMedia, $this->activities->getTable());
            }

            // collect paths to delete for removed media (after successful transaction)
            $toDelete = [];

            DB::beginTransaction();

            $activity = $this->activities->update($id, $attributes);

            if (!empty($removedIds)) {
                $medias = ActivityMedia::whereIn('id', $removedIds)->where('activity_id', $id)->get();
                $toDelete = $medias->pluck('file_url')->toArray();
                foreach ($medias as $m) {
                    $m->delete();
                }
            }

            if (!empty($storedPaths)) {
                $rows = array_map(fn($p) => ['file_url' => $p], $storedPaths);
                $activity->media()->createMany($rows);
            }

            DB::commit();

            // delete removed files from disk after successful commit
            if (!empty($toDelete)) {
                $this->storageService->deleteFiles($toDelete);
            }

            return $activity;
        } catch (\Throwable $e) {
            DB::rollBack();
            // cleanup any newly uploaded files to avoid orphans
            if (!empty($storedPaths)) {
                $this->storageService->deleteFiles($storedPaths);
            }
            throw $e;
        }
    }

    public function delete($id)
    {
        return $this->activities->delete($id);
    }

    public function activate($id)
    {
        return $this->activities->activate($id);
    }

    public function deactivate($id)
    {
        return $this->activities->deactivate($id);
    }
}
