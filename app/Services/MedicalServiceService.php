<?php

namespace App\Services;

use App\Repositories\MedicalServiceRepository;

class MedicalServiceService
{
    protected MedicalServiceRepository $services;

    public function __construct(MedicalServiceRepository $services)
    {
        $this->services = $services;
    }

    public function all(array $with = [])
    {
        return $this->services->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->services->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->services->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->services->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->services->delete($id);
    }

    public function activate($id)
    {
        return $this->services->activate($id);
    }

    public function deactivate($id)
    {
        return $this->services->deactivate($id);
    }
}
