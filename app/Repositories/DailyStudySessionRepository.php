<?php

namespace App\Repositories;

use App\Models\DailyStudySession;
use App\Models\StaffAssignment;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class DailyStudySessionRepository extends BaseRepository
{
    protected array $defaultWith = [
        'circle:id,name',
    ];

    public function __construct(DailyStudySession $model)
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

    public function userCanAccessSession(User $user, DailyStudySession $session): bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasRole('teacher')) {
            return in_array((int) $session->circle_id, $this->assignedCircleIds($user), true);
        }

        return true;
    }

    protected function scopeToUser(Builder $query, User $user): Builder
    {
        if ($user->hasRole('super-admin')) {
            return $query;
        }

        if ($user->hasRole('teacher')) {
            $circleIds = $this->assignedCircleIds($user);

            if (empty($circleIds)) {
                return $query->whereRaw('1 = 0');
            }

            return $query->whereIn($this->model->getTable() . '.circle_id', $circleIds);
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
