<?php

namespace App\Services;

use App\Repositories\MedicalFacilityCategoryRepository;

class MedicalFacilityCategoryService
{
    protected MedicalFacilityCategoryRepository $categories;

    public function __construct(MedicalFacilityCategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function all(array $with = [])
    {
        return $this->categories->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->categories->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->categories->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->categories->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->categories->delete($id);
    }

    public function activate($id)
    {
        return $this->categories->activate($id);
    }

    public function deactivate($id)
    {
        return $this->categories->deactivate($id);
    }
}
