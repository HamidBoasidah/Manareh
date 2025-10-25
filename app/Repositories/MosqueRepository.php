<?php

namespace App\Repositories;

use App\Models\Mosque;
use App\Repositories\Eloquent\BaseRepository;

class MosqueRepository extends BaseRepository
{
    public function __construct(Mosque $model)
    {
        parent::__construct($model);
    }
}
