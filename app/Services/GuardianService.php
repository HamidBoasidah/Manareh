<?php

namespace App\Services;

use App\Repositories\GuardianRepository;

class GuardianService
{
    protected GuardianRepository $guardians;

    public function __construct(GuardianRepository $guardians)
    {
        $this->guardians = $guardians;
    }

    public function all(array $with = [])
    {
        return $this->guardians->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->guardians->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->guardians->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->guardians->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->guardians->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->guardians->delete($id);
    }

    public function activate($id)
    {
        return $this->guardians->activate($id);
    }

    public function deactivate($id)
    {
        return $this->guardians->deactivate($id);
    }
}
