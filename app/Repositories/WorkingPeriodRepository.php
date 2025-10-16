<?php

namespace App\Repositories;

use App\Models\WorkingPeriod;
use App\Repositories\Eloquent\BaseRepository;

class WorkingPeriodRepository extends BaseRepository
{
    public function __construct(WorkingPeriod $model)
    {
        parent::__construct($model);
    }
}
