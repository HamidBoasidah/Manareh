<?php

namespace App\Repositories;

use App\Models\MedicalService;
use App\Repositories\Eloquent\BaseRepository;

class MedicalServiceRepository extends BaseRepository
{
    public function __construct(MedicalService $model)
    {
        parent::__construct($model);
    }
}
