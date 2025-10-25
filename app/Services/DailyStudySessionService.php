<?php

namespace App\Services;

use App\Repositories\DailyStudySessionRepository;

class DailyStudySessionService
{
    protected DailyStudySessionRepository $sessions;

    public function __construct(DailyStudySessionRepository $sessions)
    {
        $this->sessions = $sessions;
    }

    public function all(array $with = [])
    {
        return $this->sessions->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->sessions->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->sessions->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->sessions->create($attributes);
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
}
