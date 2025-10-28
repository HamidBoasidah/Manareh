<?php

namespace App\Repositories;

use App\Models\Term;
use App\Repositories\Eloquent\BaseRepository;

class TermRepository extends BaseRepository
{
    protected array $defaultWith = [
        'academicYear:id,name',
    ];

    public function __construct(Term $model)
    {
        parent::__construct($model);
    }
}
