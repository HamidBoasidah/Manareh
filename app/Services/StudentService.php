<?php

namespace App\Services;

use App\Repositories\StudentRepository;

class StudentService
{
    protected StudentRepository $students;

    public function __construct(StudentRepository $students)
    {
        $this->students = $students;
    }

    public function all(array $with = [])
    {
        return $this->students->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->students->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->students->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->students->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->students->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->students->delete($id);
    }

    public function activate($id)
    {
        return $this->students->activate($id);
    }

    public function deactivate($id)
    {
        return $this->students->deactivate($id);
    }
}
