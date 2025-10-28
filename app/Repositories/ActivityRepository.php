<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Repositories\Eloquent\BaseRepository;

class ActivityRepository extends BaseRepository
{
    protected array $defaultWith = [
        'mosque:id,name',
        'creator:id,name',
    ];

    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }
}
