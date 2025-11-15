<?php

namespace App\Repositories;

use App\Models\Exam;
use App\Models\Student;
use App\Models\StaffAssignment;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class ExamRepository extends BaseRepository
{
    protected array $defaultWith = [
        // add default relations if needed, e.g. 'examType:id,name'
    ];

    public function __construct(Exam $model)
    {
        parent::__construct($model);
    }

    public function paginateForUser(User $user, int $perPage = 15, array $with = [])
    {
        $query = $this->scopeToUser($this->builder($with), $user);

        return $query->paginate($perPage);
    }

    public function findForUser(User $user, int $id, array $with = [])
    {
        $query = $this->scopeToUser($this->builder($with), $user);

        return $query->findOrFail($id);
    }

    public function userCanAccessExam(User $user, Exam $exam): bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasRole('student')) {
            $studentId = $this->resolveStudentId($user);
            return $studentId && (int) $exam->student_id === (int) $studentId;
        }

        if ($user->hasAnyRole(['teacher', 'supervisor_tarbawi', 'supervisor_edu'])) {
            $circleIds = $this->assignedCircleIds($user);
            return in_array((int) $exam->circle_id, $circleIds, true);
        }

        return false;
    }

    protected function scopeToUser(Builder $query, User $user): Builder
    {
        if ($user->hasRole('super-admin')) {
            return $query;
        }

        if ($user->hasRole('student')) {
            $studentId = $this->resolveStudentId($user);
            if (! $studentId) {
                return $query->whereRaw('1 = 0');
            }

            return $query->where('student_id', $studentId);
        }

        if ($user->hasAnyRole(['teacher', 'supervisor_tarbawi', 'supervisor_edu'])) {
            $circleIds = $this->assignedCircleIds($user);
            if (empty($circleIds)) {
                return $query->whereRaw('1 = 0');
            }

            return $query->whereIn('circle_id', $circleIds);
        }

        // default: deny access
        return $query->whereRaw('1 = 0');
    }

    protected function resolveStudentId(User $user): ?int
    {
        return Student::where('user_id', $user->id)->value('id');
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
