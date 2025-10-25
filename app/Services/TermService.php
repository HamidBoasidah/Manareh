<?php

namespace App\Services;

use App\Repositories\TermRepository;

class TermService
{
    protected TermRepository $terms;

    public function __construct(TermRepository $terms)
    {
        $this->terms = $terms;
    }

    public function all(array $with = [])
    {
        return $this->terms->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->terms->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->terms->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->terms->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->terms->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->terms->delete($id);
    }

    public function activate($id)
    {
        return $this->terms->activate($id);
    }

    public function deactivate($id)
    {
        return $this->terms->deactivate($id);
    }
}
