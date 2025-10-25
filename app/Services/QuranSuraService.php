<?php

namespace App\Services;

use App\Repositories\QuranSuraRepository;

class QuranSuraService
{
    protected QuranSuraRepository $suras;

    public function __construct(QuranSuraRepository $suras)
    {
        $this->suras = $suras;
    }

    public function all(array $with = [])
    {
        return $this->suras->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->suras->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->suras->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->suras->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->suras->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->suras->delete($id);
    }

    public function activate($id)
    {
        return $this->suras->activate($id);
    }

    public function deactivate($id)
    {
        return $this->suras->deactivate($id);
    }
}
