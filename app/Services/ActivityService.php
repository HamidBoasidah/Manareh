<?php

namespace App\Services;

use App\Repositories\ActivityRepository;

class ActivityService
{
    protected ActivityRepository $activities;

    public function __construct(ActivityRepository $activities)
    {
        $this->activities = $activities;
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

    public function create(array $attributes)
    {
        return $this->activities->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->activities->update($id, $attributes);
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
