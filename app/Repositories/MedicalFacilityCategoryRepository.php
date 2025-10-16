<?php

namespace App\Repositories;

use App\Models\MedicalFacilityCategory;
use App\Repositories\Eloquent\BaseRepository;

class MedicalFacilityCategoryRepository extends BaseRepository
{
    public function __construct(MedicalFacilityCategory $model)
    {
        parent::__construct($model);
    }
}
