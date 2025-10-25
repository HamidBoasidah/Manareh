<?php

namespace App\Repositories;

use App\Models\Circle;
use App\Repositories\Eloquent\BaseRepository;

class CircleRepository extends BaseRepository
{
    public function __construct(Circle $model)
    {
        parent::__construct($model);
    }
}
