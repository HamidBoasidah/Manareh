<?php

namespace App\Repositories;

use App\Models\MedicalFacility;
use App\Repositories\Eloquent\BaseRepository;

class MedicalFacilityRepository extends BaseRepository
{
    public function __construct(MedicalFacility $model)
    {
        parent::__construct($model);
    }
}
