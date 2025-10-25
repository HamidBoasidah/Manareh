<?php

namespace App\Services;

use App\Repositories\ActivityMediaRepository;

class ActivityMediaService
{
    protected ActivityMediaRepository $media;

    public function __construct(ActivityMediaRepository $media)
    {
        $this->media = $media;
    }

    public function all(array $with = [])
    {
        return $this->media->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->media->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->media->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->media->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->media->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->media->delete($id);
    }

    public function activate($id)
    {
        return $this->media->activate($id);
    }

    public function deactivate($id)
    {
        return $this->media->deactivate($id);
    }
}
