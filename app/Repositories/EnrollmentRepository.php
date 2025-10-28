<?php

namespace App\Repositories;

use App\Models\Enrollment;
use App\Repositories\Eloquent\BaseRepository;

class EnrollmentRepository extends BaseRepository
{
    protected array $defaultWith = [
        'circle:id,name',
        'student:id,user_id,guardian_id',
        'student.user:id,name',
        'student.guardian:id,name,phone_number',
    ];

    public function __construct(Enrollment $model)
    {
        parent::__construct($model);
    }
}
