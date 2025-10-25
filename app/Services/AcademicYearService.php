<?php

namespace App\Services;

use App\Repositories\AcademicYearRepository;

class AcademicYearService
{
    protected AcademicYearRepository $years;

    public function __construct(AcademicYearRepository $years)
    {
        $this->years = $years;
    }

    public function all(array $with = [])
    {
        return $this->years->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->years->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->years->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->years->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->years->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->years->delete($id);
    }

    public function activate($id)
    {
        return $this->years->activate($id);
    }

    public function deactivate($id)
    {
        return $this->years->deactivate($id);
    }
}
