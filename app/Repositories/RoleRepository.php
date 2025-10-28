<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Eloquent\BaseRepository;

class RoleRepository extends BaseRepository
{
    protected array $defaultWith = [
        'permissions:id,name',
    ];

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 10, array $with = [])
    {
        return $this->query()
            ->with($this->applyDefaultWith($with))
            ->withCount('permissions')
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $attributes)
    {
        
        $role = $this->model->newQuery()->create([
            'name'        => $attributes['name'],
            'guard_name'  => $attributes['guard_name'] ?? 'web',
        ]);

        if (!empty($attributes['display_name'])) {
            // يدعم التعيين المباشر أو setTranslations
            $role->setTranslations('display_name', $attributes['display_name']);
            $role->save();
        }

        return $role;
    }

    public function update($id, array $attributes)
    {
        $role = $this->findOrFail($id);

        $role->fill([
            'name'       => $attributes['name'] ?? $role->name,
            'guard_name' => $attributes['guard_name'] ?? $role->guard_name,
        ]);

        if (array_key_exists('display_name', $attributes)) {
            $role->setTranslations('display_name', $attributes['display_name'] ?? []);
        }

        $role->save();

        return $role;
    }
}
