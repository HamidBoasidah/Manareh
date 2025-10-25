<?php

namespace App\Services;

use App\Repositories\CircleRepository;

class CircleService
{
    protected CircleRepository $circles;

    public function __construct(CircleRepository $circles)
    {
        $this->circles = $circles;
    }

    public function all(array $with = [])
    {
        return $this->circles->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->circles->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->circles->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->circles->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->circles->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->circles->delete($id);
    }

    public function activate($id)
    {
        return $this->circles->activate($id);
    }

    public function deactivate($id)
    {
        return $this->circles->deactivate($id);
    }
}
