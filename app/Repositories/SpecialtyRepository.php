<?php

namespace App\Repositories;

use App\Models\Specialty;
use App\Repositories\Eloquent\BaseRepository;

class SpecialtyRepository extends BaseRepository
{
    public function __construct(Specialty $model)
    {
        parent::__construct($model);
    }
}
