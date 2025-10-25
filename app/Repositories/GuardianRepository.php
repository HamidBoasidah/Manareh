<?php

namespace App\Repositories;

use App\Models\Guardian;
use App\Repositories\Eloquent\BaseRepository;

class GuardianRepository extends BaseRepository
{
    public function __construct(Guardian $model)
    {
        parent::__construct($model);
    }
}
