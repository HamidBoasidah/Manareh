<?php

namespace App\Services;

use App\Repositories\MedicalFacilityRepository;

class MedicalFacilityService
{
    protected MedicalFacilityRepository $facilities;

    public function __construct(MedicalFacilityRepository $facilities)
    {
        $this->facilities = $facilities;
    }

    public function all(array $with = [])
    {
        return $this->facilities->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->facilities->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->facilities->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->facilities->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->facilities->delete($id);
    }

    public function activate($id)
    {
        return $this->facilities->activate($id);
    }

    public function deactivate($id)
    {
        return $this->facilities->deactivate($id);
    }
}
