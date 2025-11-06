<?php

namespace App\Repositories;

use App\Models\Exam;
use App\Repositories\Eloquent\BaseRepository;

class ExamRepository extends BaseRepository
{
    protected array $defaultWith = [
        // add default relations if needed, e.g. 'examType:id,name'
    ];

    public function __construct(Exam $model)
    {
        parent::__construct($model);
    }
}
