<?php

namespace App\Services;

use App\Repositories\EnrollmentRepository;

class EnrollmentService
{
    protected EnrollmentRepository $enrollments;

    public function __construct(EnrollmentRepository $enrollments)
    {
        $this->enrollments = $enrollments;
    }

    public function all(array $with = [])
    {
        return $this->enrollments->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->enrollments->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->enrollments->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->enrollments->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->enrollments->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->enrollments->delete($id);
    }

    public function activate($id)
    {
        return $this->enrollments->activate($id);
    }

    public function deactivate($id)
    {
        return $this->enrollments->deactivate($id);
    }
}
