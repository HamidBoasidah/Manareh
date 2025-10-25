<?php

namespace App\Services;

use App\Repositories\StaffAssignmentRepository;

class StaffAssignmentService
{
    protected StaffAssignmentRepository $assignments;

    public function __construct(StaffAssignmentRepository $assignments)
    {
        $this->assignments = $assignments;
    }

    public function all(array $with = [])
    {
        return $this->assignments->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->assignments->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->assignments->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->assignments->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->assignments->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->assignments->delete($id);
    }

    public function activate($id)
    {
        return $this->assignments->activate($id);
    }

    public function deactivate($id)
    {
        return $this->assignments->deactivate($id);
    }
}
