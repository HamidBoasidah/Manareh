<?php

namespace App\Repositories;

use App\Models\Nomination;
use App\Repositories\Eloquent\BaseRepository;

class NominationRepository extends BaseRepository
{
    protected array $defaultWith = [
        'circle:id,name',
        'student:id,user_id',
        'student.user:id,name',
        'academicYear:id,name',
        'nominatedBy:id,name',
    ];
    public function __construct(Nomination $model)
    {
        parent::__construct($model);
    }
}
