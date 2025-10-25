<?php

namespace App\Repositories;

use App\Models\TeacherAttendance;
use App\Repositories\Eloquent\BaseRepository;

class TeacherAttendanceRepository extends BaseRepository
{
    public function __construct(TeacherAttendance $model)
    {
        parent::__construct($model);
    }
}
