<?php

namespace App\Services;

use App\Events\StudentAddedToCircle;
use App\Repositories\CircleRepository;
use App\Models\Circle;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CircleService
{
    protected CircleRepository $circles;

    public function __construct(CircleRepository $circles)
    {
        $this->circles = $circles;
    }

    public function all(array $with = [])
    {
        return $this->circles->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->circles->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->circles->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->circles->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->circles->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->circles->delete($id);
    }

    public function activate($id)
    {
        return $this->circles->activate($id);
    }

    public function deactivate($id)
    {
        return $this->circles->deactivate($id);
    }

    public function getJoinedStudents(int $circleId)
    {
        return Circle::findOrFail($circleId)
            ->currentStudents()
            ->with(['user:id,name']) // الاسم من جدول users
            ->orderBy(
                User::select('name')->whereColumn('users.id', 'students.user_id')
            )
            ->get(['students.id', 'students.user_id']) // أعمدة قليلة
            ->map(fn($s) => [
                'id'   => $s->id,
                'name' => $s->user?->name ?? '—',
            ]);
    }
    
    public function getFreeStudents()
    {
        return Student::query()
            ->free()
            ->with(['user:id,name']) // الاسم من جدول users
            ->orderBy(
                User::select('name')->whereColumn('users.id', 'students.user_id')
            )
            ->get(['students.id', 'students.user_id'])
            ->map(fn($s) => [
                'id'   => $s->id,
                'name' => $s->user?->name ?? '—',
            ]);
    }

    public function attachStudent(int $circleId, int $studentId): void
    {
        $circle = Circle::findOrFail($circleId);
        $student = Student::findOrFail($studentId);

        $this->ensureCircleHasCapacity($circle);

        if ($student->enrollments()->whereNull('left_at')->exists()) {
            throw ValidationException::withMessages([
                'student_id' => __('circles.studentAlreadyAssigned'),
            ]);
        }

        $circle->enrollments()->create([
            'student_id' => $student->id,
            'joined_at' => now()->toDateString(),
            'left_at' => null,
        ]);

        $teacher = $this->resolveActiveTeacher($circle);

        event(new StudentAddedToCircle($student, $circle->fresh(), $teacher));
    }

    public function detachStudent(int $circleId, int $studentId): void
    {
        $circle = Circle::findOrFail($circleId);

        $enrollment = $circle->enrollments()
            ->where('student_id', $studentId)
            ->whereNull('left_at')
            ->first();

        if (! $enrollment) {
            throw ValidationException::withMessages([
                'student_id' => __('circles.studentNotEnrolled'),
            ]);
        }

        $enrollment->update([
            'left_at' => now()->toDateString(),
        ]);
    }

    private function ensureCircleHasCapacity(Circle $circle): void
    {
        if (is_null($circle->capacity)) {
            return;
        }

        $activeCount = $circle->enrollments()->whereNull('left_at')->count();

        if ($activeCount >= $circle->capacity) {
            throw ValidationException::withMessages([
                'circle_id' => __('circles.circleCapacityReached'),
            ]);
        }
    }

    private function resolveActiveTeacher(Circle $circle): ?User
    {
        $circle->loadMissing([
            'staffAssignments' => fn ($query) => $query
                ->whereNull('end_at')
                ->with(['user:id,name', 'role:id,name'])
                ->orderByDesc('start_at'),
        ]);

        $assignment = $circle->staffAssignments->first(function ($assignment) {
            $roleName = $assignment->role?->name;
            if (! $roleName) {
                return false;
            }

            return Str::contains($roleName, ['معلم', 'teacher'], true);
        }) ?? $circle->staffAssignments->first();

        return $assignment?->user;
    }
}
