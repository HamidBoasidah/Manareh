<?php

namespace App\Services;

use App\Repositories\DailyStudyRepository;

class DailyStudyService
{
    protected DailyStudyRepository $studies;

    public function __construct(DailyStudyRepository $studies)
    {
        $this->studies = $studies;
    }

    public function all(array $with = [])
    {
        return $this->studies->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->studies->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->studies->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->studies->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->studies->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->studies->delete($id);
    }

    public function activate($id)
    {
        return $this->studies->activate($id);
    }

    public function deactivate($id)
    {
        return $this->studies->deactivate($id);
    }
}
