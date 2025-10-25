<?php

namespace App\Repositories;

use App\Models\CircleClassification;
use App\Repositories\Eloquent\BaseRepository;

class CircleClassificationRepository extends BaseRepository
{
    public function __construct(CircleClassification $model)
    {
        parent::__construct($model);
    }
}
