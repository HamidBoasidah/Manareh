<?php

namespace App\Repositories;

use App\Models\Term;
use App\Repositories\Eloquent\BaseRepository;

class TermRepository extends BaseRepository
{
    public function __construct(Term $model)
    {
        parent::__construct($model);
    }
}
