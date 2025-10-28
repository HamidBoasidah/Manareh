<?php

namespace App\Repositories;

use App\Models\Circle;
use App\Repositories\Eloquent\BaseRepository;

class CircleRepository extends BaseRepository
{
    protected array $defaultWith = [
        'mosque:id,name',
        'classification:id,name',
    ];

    public function __construct(Circle $model)
    {
        parent::__construct($model);
    }
}
