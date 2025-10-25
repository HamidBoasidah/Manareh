<?php

namespace App\Services;

use App\Repositories\ExamTypeRepository;

class ExamTypeService
{
    protected ExamTypeRepository $types;

    public function __construct(ExamTypeRepository $types)
    {
        $this->types = $types;
    }

    public function all(array $with = [])
    {
        return $this->types->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->types->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->types->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->types->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->types->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->types->delete($id);
    }

    public function activate($id)
    {
        return $this->types->activate($id);
    }

    public function deactivate($id)
    {
        return $this->types->deactivate($id);
    }
}
