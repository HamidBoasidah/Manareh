<?php

namespace App\Repositories;

use App\Models\StaffAssignment;
use App\Repositories\Eloquent\BaseRepository;

class StaffAssignmentRepository extends BaseRepository
{
    public function __construct(StaffAssignment $model)
    {
        parent::__construct($model);
    }
}
