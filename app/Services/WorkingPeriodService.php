<?php

namespace App\Services;

use App\Repositories\WorkingPeriodRepository;

class WorkingPeriodService
{
    protected WorkingPeriodRepository $periods;

    public function __construct(WorkingPeriodRepository $periods)
    {
        $this->periods = $periods;
    }

    public function all(array $with = [])
    {
        return $this->periods->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->periods->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->periods->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->periods->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->periods->delete($id);
    }

    public function activate($id)
    {
        return $this->periods->activate($id);
    }

    public function deactivate($id)
    {
        return $this->periods->deactivate($id);
    }
}
