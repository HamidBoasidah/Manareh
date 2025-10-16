<?php

namespace App\Services;

use App\Repositories\AdvertisementRepository;

class AdvertisementService
{
    protected AdvertisementRepository $ads;

    public function __construct(AdvertisementRepository $ads)
    {
        $this->ads = $ads;
    }

    public function all(array $with = [])
    {
        return $this->ads->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->ads->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->ads->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->ads->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->ads->delete($id);
    }

    public function activate($id)
    {
        return $this->ads->activate($id);
    }

    public function deactivate($id)
    {
        return $this->ads->deactivate($id);
    }
}
