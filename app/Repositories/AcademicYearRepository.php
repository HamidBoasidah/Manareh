<?php

namespace App\Repositories;

use App\Models\AcademicYear;
use App\Repositories\Eloquent\BaseRepository;

class AcademicYearRepository extends BaseRepository
{
    protected array $defaultWith = [
        'mosque:id,name',
    ];

    public function __construct(AcademicYear $model)
    {
        parent::__construct($model);
    }
}
