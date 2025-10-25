<?php

namespace App\Services;

use App\Repositories\NominationRepository;

class NominationService
{
    protected NominationRepository $nominations;

    public function __construct(NominationRepository $nominations)
    {
        $this->nominations = $nominations;
    }

    public function all(array $with = [])
    {
        return $this->nominations->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->nominations->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->nominations->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->nominations->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->nominations->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->nominations->delete($id);
    }

    public function activate($id)
    {
        return $this->nominations->activate($id);
    }

    public function deactivate($id)
    {
        return $this->nominations->deactivate($id);
    }
}
