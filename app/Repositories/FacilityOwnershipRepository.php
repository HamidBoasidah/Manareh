<?php

namespace App\Repositories;

use App\Models\FacilityOwnership;
use App\Repositories\Eloquent\BaseRepository;

class FacilityOwnershipRepository extends BaseRepository
{
    public function __construct(FacilityOwnership $model)
    {
        parent::__construct($model);
    }
}
