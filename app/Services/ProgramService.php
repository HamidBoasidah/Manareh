<?php

namespace App\Services;

use App\Repositories\ProgramRepository;

class ProgramService
{
    protected ProgramRepository $programs;

    public function __construct(ProgramRepository $programs)
    {
        $this->programs = $programs;
    }

    public function all(array $with = [])
    {
        return $this->programs->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->programs->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->programs->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->programs->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->programs->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->programs->delete($id);
    }

    public function activate($id)
    {
        return $this->programs->activate($id);
    }

    public function deactivate($id)
    {
        return $this->programs->deactivate($id);
    }
}
