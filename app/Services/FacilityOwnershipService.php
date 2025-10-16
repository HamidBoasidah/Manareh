<?php

namespace App\Services;

use App\Repositories\FacilityOwnershipRepository;

class FacilityOwnershipService
{
    protected FacilityOwnershipRepository $ownerships;

    public function __construct(FacilityOwnershipRepository $ownerships)
    {
        $this->ownerships = $ownerships;
    }

    public function all(array $with = [])
    {
        return $this->ownerships->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->ownerships->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->ownerships->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->ownerships->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->ownerships->delete($id);
    }

    public function activate($id)
    {
        return $this->ownerships->activate($id);
    }

    public function deactivate($id)
    {
        return $this->ownerships->deactivate($id);
    }
}
