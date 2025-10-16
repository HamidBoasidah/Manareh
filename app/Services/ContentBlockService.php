<?php

namespace App\Services;

use App\Repositories\ContentBlockRepository;

class ContentBlockService
{
    protected ContentBlockRepository $blocks;

    public function __construct(ContentBlockRepository $blocks)
    {
        $this->blocks = $blocks;
    }

    public function all(array $with = [])
    {
        return $this->blocks->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->blocks->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->blocks->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->blocks->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->blocks->delete($id);
    }

    public function activate($id)
    {
        return $this->blocks->activate($id);
    }

    public function deactivate($id)
    {
        return $this->blocks->deactivate($id);
    }
}
