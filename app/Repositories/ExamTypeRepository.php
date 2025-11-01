<?php

namespace App\Repositories;

use App\Models\ExamType;
use App\Repositories\Eloquent\BaseRepository;

class ExamTypeRepository extends BaseRepository
{
    protected array $defaultWith = [
        'mosque:id,name',
    ];

    public function __construct(ExamType $model)
    {
        parent::__construct($model);
    }
}
