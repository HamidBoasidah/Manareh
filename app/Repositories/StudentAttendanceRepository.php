<?php

namespace App\Repositories;

use App\Models\StudentAttendance;
use App\Repositories\Eloquent\BaseRepository;

class StudentAttendanceRepository extends BaseRepository
{
    protected array $defaultWith = [
        'circle:id,name',
        'student:id,user_id,guardian_id',
        'student.user:id,name',
        'student.guardian:id,name,phone_number',
        'recorder:id,name',
    ];

    public function __construct(StudentAttendance $model)
    {
        parent::__construct($model);
    }
}
