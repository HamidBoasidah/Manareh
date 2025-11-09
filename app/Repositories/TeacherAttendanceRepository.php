<?php

namespace App\Repositories;

use App\Models\TeacherAttendance;
use App\Repositories\Eloquent\BaseRepository;

class TeacherAttendanceRepository extends BaseRepository
{
    protected array $defaultWith = [
        'circle:id,name',
        'user:id,name',
        'recordedBy:id,name',
    ];

    public function __construct(TeacherAttendance $model)
    {
        parent::__construct($model);
    }
}
