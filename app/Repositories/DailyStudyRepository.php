<?php

namespace App\Repositories;

use App\Models\DailyStudy;
use App\Repositories\Eloquent\BaseRepository;

class DailyStudyRepository extends BaseRepository
{
    protected array $defaultWith = [
        'student.user:id,name',
    ];

    public function __construct(DailyStudy $model)
    {
        parent::__construct($model);
    }

    public function forSession(int $sessionId)
    {
        return $this->builder()->where('session_id', $sessionId)->get();
    }
}
