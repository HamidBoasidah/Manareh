<?php

namespace App\Services;

use App\Repositories\MosqueRepository;

class MosqueService
{
    protected MosqueRepository $mosques;

    public function __construct(MosqueRepository $mosques)
    {
        $this->mosques = $mosques;
    }

    public function all(array $with = [])
    {
        return $this->mosques->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->mosques->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->mosques->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->mosques->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->mosques->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->mosques->delete($id);
    }

    public function activate($id)
    {
        return $this->mosques->activate($id);
    }

    public function deactivate($id)
    {
        return $this->mosques->deactivate($id);
    }
}
