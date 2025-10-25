<?php

namespace App\Services;

use App\Repositories\PlanRepository;

class PlanService
{
    protected PlanRepository $plans;

    public function __construct(PlanRepository $plans)
    {
        $this->plans = $plans;
    }

    public function all(array $with = [])
    {
        return $this->plans->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->plans->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->plans->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->plans->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->plans->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->plans->delete($id);
    }

    public function activate($id)
    {
        return $this->plans->activate($id);
    }

    public function deactivate($id)
    {
        return $this->plans->deactivate($id);
    }
}
