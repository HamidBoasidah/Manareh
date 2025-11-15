<?php

namespace App\Services;

use App\Repositories\DailyStudySessionRepository;
use App\Repositories\DailyStudyRepository;
use App\Models\Enrollment;
use App\Models\DailyStudySession;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DailyStudySessionService
{
    protected DailyStudySessionRepository $sessions;
    protected DailyStudyRepository $studies;

    public function __construct(DailyStudySessionRepository $sessions, DailyStudyRepository $studies)
    {
        $this->sessions = $sessions;
        $this->studies = $studies;
    }

    public function all(array $with = [])
    {
        return $this->sessions->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->sessions->paginate($perPage, $with);
    }

    public function paginateForUser(User $user, int $perPage = 15, array $with = [])
    {
        return $this->sessions->paginateForUser($user, $perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->sessions->findOrFail($id, $with);
    }

    public function findForUser(User $user, int|string $id, array $with = [])
    {
        return $this->sessions->findForUser($user, $id, $with);
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $session = $this->sessions->create($attributes);

            $studentIds = Enrollment::query()
                ->where('circle_id', $session->circle_id)
                ->current()
                ->pluck('student_id')
                ->unique()
                ->values();

            if ($studentIds->isNotEmpty()) {
                $timestamp = now();

                $this->studies->query()->insert(
                    $studentIds->map(fn ($studentId) => [
                        'session_id' => $session->id,
                        'student_id' => $studentId,
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ])->all()
                );
            }

            return $session;
        });
    }

    public function update($id, array $attributes)
    {
        return $this->sessions->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->sessions->delete($id);
    }

    public function activate($id)
    {
        return $this->sessions->activate($id);
    }

    public function deactivate($id)
    {
        return $this->sessions->deactivate($id);
    }

    public function userCanAccessSession(User $user, DailyStudySession $session): bool
    {
        return $this->sessions->userCanAccessSession($user, $session);
    }
}
