<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Eloquent\BaseRepository;

class StudentRepository extends BaseRepository
{
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }
}
