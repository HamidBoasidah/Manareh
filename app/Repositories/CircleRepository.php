<?php

namespace App\Repositories;

use App\Models\Circle;
use App\Models\StaffAssignment;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class CircleRepository extends BaseRepository
{
    protected array $defaultWith = [
        'mosque:id,name',
        'classification:id,name',
    ];

    public function __construct(Circle $model)
    {
        parent::__construct($model);
    }

    public function paginateForUser(User $user, int $perPage = 15, array $with = [])
    {
        $query = $this->scopeToUser($this->builder($with), $user);

        return $query->paginate($perPage);
    }

    public function findForUser(User $user, int|string $id, array $with = [])
    {
        $query = $this->scopeToUser($this->builder($with), $user);

        return $query->findOrFail($id);
    }

    public function userCanAccessCircle(User $user, Circle $circle): bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyRole(['supervisor_tarbawi', 'supervisor_edu'])) {
            return in_array((int) $circle->id, $this->assignedCircleIds($user), true);
        }

        return true;
    }

    protected function scopeToUser(Builder $query, User $user): Builder
    {
        if ($user->hasRole('super-admin')) {
            return $query;
        }

        if ($user->hasAnyRole(['supervisor_tarbawi', 'supervisor_edu'])) {
            $circleIds = $this->assignedCircleIds($user);

            if (empty($circleIds)) {
                return $query->whereRaw('1 = 0');
            }

            return $query->whereIn($this->model->getTable() . '.id', $circleIds);
        }

        return $query;
    }

    protected function assignedCircleIds(User $user): array
    {
        return StaffAssignment::query()
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->pluck('circle_id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }
}
