<?php

namespace App\Repositories;

use App\Models\ContentBlock;
use App\Repositories\Eloquent\BaseRepository;

class ContentBlockRepository extends BaseRepository
{
    public function __construct(ContentBlock $model)
    {
        parent::__construct($model);
    }
}
