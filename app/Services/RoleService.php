<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\DB;

class RoleService
{
    protected RoleRepository $roles;

    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
    }

    public function all(array $with = [])
    {
        return $this->roles->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->roles->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $role = $this->roles->create($attributes);

            if (!empty($attributes['permissions'])) {
                $role->syncPermissions((array) $attributes['permissions']);
            }

            return $role->loadCount('permissions')->load('permissions:id,name');
        });
    }

    public function update($id, array $attributes)
    {
        return DB::transaction(function () use ($id, $attributes) {
            $role = $this->roles->update($id, $attributes);

            if (array_key_exists('permissions', $attributes)) {
                $role->syncPermissions((array) ($attributes['permissions'] ?? []));
            }

            return $role->loadCount('permissions')->load('permissions:id,name');
        });
    }

    public function delete($id)
    {
        return $this->roles->delete($id);
    }

    public function paginate($perPage = 10, $with = [])
    {
        return $this->roles->paginate($perPage, $with);
    }
}