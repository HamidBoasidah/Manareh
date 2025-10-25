<?php

namespace App\Repositories;

use App\Models\StudentAttendance;
use App\Repositories\Eloquent\BaseRepository;

class StudentAttendanceRepository extends BaseRepository
{
    public function __construct(StudentAttendance $model)
    {
        parent::__construct($model);
    }
}
