<?php

namespace App\Repositories;

use App\Models\StaffAssignment;
use App\Repositories\Eloquent\BaseRepository;

class StaffAssignmentRepository extends BaseRepository
{
    protected array $defaultWith = [
        'user:id,name',
        'circle:id,name',
    ];

    public function __construct(StaffAssignment $model)
    {
        parent::__construct($model);
    }
}
