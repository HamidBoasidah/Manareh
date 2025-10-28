<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Eloquent\BaseRepository;

class StudentRepository extends BaseRepository
{
    protected array $defaultWith = [
        'user:id,name,email',
        'guardian:id,name,phone_number',
        'mosque:id,name',
    ];

    public function __construct(Student $model)
    {
        parent::__construct($model);
    }
}
