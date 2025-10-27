<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Repositories\Eloquent\BaseRepository;

class ActivityRepository extends BaseRepository
{
    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }
}
