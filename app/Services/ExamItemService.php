<?php

namespace App\Services;

use App\Repositories\ExamItemRepository;

class ExamItemService
{
    protected ExamItemRepository $items;

    public function __construct(ExamItemRepository $items)
    {
        $this->items = $items;
    }

    public function all(array $with = [])
    {
        return $this->items->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->items->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->items->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->items->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->items->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->items->delete($id);
    }

    public function activate($id)
    {
        return $this->items->activate($id);
    }

    public function deactivate($id)
    {
        return $this->items->deactivate($id);
    }
}
