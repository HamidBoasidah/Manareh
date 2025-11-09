<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    /** علاقات تُحمَّل افتراضياً (يمكن لكل مستودع override) */
    protected array $defaultWith = []; 
    // مثال في DistrictRepository: ['governorate' => ['id','name_ar','name_en']]

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected function applyWith($query, array $with = [])
    {
        // دمج الوحدات: السماح بتمرير with عند النداء + المزج مع الافتراضي
        $merged = array_replace($this->defaultWith, $with);

        foreach ($merged as $relation => $cols) {
            if (is_int($relation)) {
                // صيغة: ['governorate', 'services']
                $query->with($cols);
            } else {
                // صيغة: ['governorate' => ['id','name_ar','name_en']]
                $query->with([
                    $relation => function ($q) use ($cols) {
                        $q->select($cols);
                    }
                ]);
            }
        }

        return $query;
    }

    public function query()
    {
        return $this->model->newQuery();
    }

    /**
     * Return the underlying model instance.
     * Useful for callers that need model metadata (table name, etc.).
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Return model table name.
     */
    public function getTable(): string
    {
        return $this->model->getTable();
    }

    public function builder(array $with = []): Builder
    {
        return $this->applyWith($this->query(), $with);
    }

    public function all(array $with = [])
    {
        $q = $this->applyWith($this->query(), $with);
        return $q->latest()->get();
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        $q = $this->applyWith($this->query(), $with);
        return $q->latest()->paginate($perPage);
    }

    public function find(int|string $id, array $with = [])
    {
        $q = $this->applyWith($this->query(), $with);
        return $q->find($id);
    }

    public function findOrFail(int|string $id, array $with = [])
    {
        $q = $this->applyWith($this->query(), $with);
        return $q->findOrFail($id);
    }

    public function create(array $attributes)
    {
        $attributes = $this->handleFileUploads($attributes);

        // Extract any related file arrays (e.g. 'media' => ['path1','path2'])
        $relatedFiles = [];
        foreach ($attributes as $key => $value) {
            if (is_array($value) && method_exists($this->model, $key)) {
                $relatedFiles[$key] = $value;
                unset($attributes[$key]);
            }
        }

        $record = $this->model->create($attributes);

        // Create related hasMany records for stored files (best-effort)
        foreach ($relatedFiles as $relation => $paths) {
            try {
                if (method_exists($record, $relation)) {
                    $relationObj = $record->$relation();
                    // only handle HasMany-like relations
                    if ($relationObj instanceof \Illuminate\Database\Eloquent\Relations\HasMany) {
                        $relatedModel = $relationObj->getRelated();
                        $fileColumn = $this->detectFileColumn($relatedModel);
                        $rows = array_map(function ($p) use ($fileColumn) {
                            return [$fileColumn => $p];
                        }, $paths);
                        // createMany may fail if timestamps/fillable mismatch; use create per row as fallback
                        try {
                            $relationObj->createMany($rows);
                        } catch (\Throwable $e) {
                            foreach ($rows as $r) {
                                $relationObj->create($r);
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                // swallow to avoid breaking generic repository behavior
            }
        }

        return $record;
    }

    public function update(int|string $id, array $attributes)
    {
        $record = $this->findOrFail($id);
        $attributes = $this->handleFileUploads($attributes, $record);

        // Collect related files to attach after update
        $relatedFiles = [];
        foreach ($attributes as $key => $value) {
            if (is_array($value) && method_exists($record, $key)) {
                $relatedFiles[$key] = $value;
                unset($attributes[$key]);
            }
        }

        $record->update($attributes);

        // Attach related files as hasMany records
        foreach ($relatedFiles as $relation => $paths) {
            try {
                if (method_exists($record, $relation)) {
                    $relationObj = $record->$relation();
                    if ($relationObj instanceof \Illuminate\Database\Eloquent\Relations\HasMany) {
                        $relatedModel = $relationObj->getRelated();
                        $fileColumn = $this->detectFileColumn($relatedModel);
                        foreach ($paths as $p) {
                            try {
                                $relationObj->create([$fileColumn => $p]);
                            } catch (\Throwable $e) {
                                // ignore single failures
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return $record;
    }

    public function delete(int|string $id): bool
    {
        $record = $this->findOrFail($id);
        return (bool) $record->delete();
    }

    public function activate(int|string $id)
    {
        $record = $this->findOrFail($id);
        $record->update(['is_active' => true]);
        return $record;
    }

    public function deactivate(int|string $id)
    {
        $record = $this->findOrFail($id);
        $record->update(['is_active' => false]);
        return $record;
    }

    /**
     * يعالج رفع الملفات ويستبدل كائن الملف بالمسار.
     *
     * @param array $attributes
     * @param Model|null $record السجل الحالي (يستخدم في التحديث لحذف الملف القديم)
     * @return array
     */
    protected function handleFileUploads(array $attributes, ?Model $record = null): array
    {
        // Use the shared FileStorageService so storage logic is centralized.
        $storage = null;
        try {
            $storage = app()->make(\App\Services\FileStorageService::class);
        } catch (\Throwable $_) {
            $storage = null;
        }

        foreach ($attributes as $key => &$value) {
            // Single file
            if ($value instanceof UploadedFile) {
                // delete old file if present (on update)
                if ($record && $record->{$key} && Storage::disk('public')->exists($record->{$key})) {
                    Storage::disk('public')->delete($record->{$key});
                }
                if ($storage) {
                    $paths = $storage->storeFiles([$value], $this->model->getTable());
                    $value = $paths[0] ?? null;
                } else {
                    $path = $value->store($this->model->getTable(), 'public');
                    $value = $path; // replace file object with stored path
                }
                continue;
            }

            // Multiple files (array of UploadedFile)
            if (is_array($value)) {
                // if a storage service is available, batch store; otherwise store inline
                $paths = [];
                $uploadedItems = [];
                foreach ($value as $item) {
                    if ($item instanceof UploadedFile) {
                        $uploadedItems[] = $item;
                    } elseif (is_string($item)) {
                        $paths[] = $item;
                    }
                }

                if ($storage && !empty($uploadedItems)) {
                    $stored = $storage->storeFiles($uploadedItems, $this->model->getTable());
                    $paths = array_merge($paths, $stored);
                } else {
                    foreach ($uploadedItems as $it) {
                        $paths[] = $it->store($this->model->getTable(), 'public');
                    }
                }

                $value = $paths; // replace array of files with array of stored paths
            }
        }

        return $attributes;
    }

    /**
     * Attempt to detect the most likely file column on a related model.
     * Common candidates: file_url, path, file_path, url
     */
    protected function detectFileColumn(Model $model): string
    {
        $candidates = ['file_url', 'path', 'file_path', 'url'];
        $fillable = $model->getFillable();
        foreach ($candidates as $c) {
            if (in_array($c, $fillable)) return $c;
        }
        // fallback to first fillable or 'file_url'
        return $fillable[0] ?? 'file_url';
    }
}
