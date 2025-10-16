<?php

namespace App\Services;

use App\Repositories\SpecialtyRepository;

class SpecialtyService
{
    protected SpecialtyRepository $specialties;

    public function __construct(SpecialtyRepository $specialties)
    {
        $this->specialties = $specialties;
    }

    public function all(array $with = [])
    {
        return $this->specialties->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->specialties->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->specialties->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->specialties->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->specialties->delete($id);
    }

    public function activate($id)
    {
        return $this->specialties->activate($id);
    }

    public function deactivate($id)
    {
        return $this->specialties->deactivate($id);
    }
}
