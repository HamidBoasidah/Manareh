<?php

namespace App\Repositories;

use App\Models\Program;
use App\Repositories\Eloquent\BaseRepository;

class ProgramRepository extends BaseRepository
{
    public function __construct(Program $model)
    {
        parent::__construct($model);
    }
}
