<?php

namespace App\Repositories;

use App\Models\DailyStudySession;
use App\Repositories\Eloquent\BaseRepository;

class DailyStudySessionRepository extends BaseRepository
{
    protected array $defaultWith = [
        'circle:id,name',
    ];

    public function __construct(DailyStudySession $model)
    {
        parent::__construct($model);
    }
}
