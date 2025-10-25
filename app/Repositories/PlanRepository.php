<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Repositories\Eloquent\BaseRepository;

class PlanRepository extends BaseRepository
{
    public function __construct(Plan $model)
    {
        parent::__construct($model);
    }
}
