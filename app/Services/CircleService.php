<?php

namespace App\Services;

use App\Repositories\CircleRepository;
use App\Models\Circle;
use App\Models\Student;
use App\Models\User;
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
}
