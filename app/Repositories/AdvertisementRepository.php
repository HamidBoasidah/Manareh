<?php

namespace App\Repositories;

use App\Models\Advertisement;
use App\Repositories\Eloquent\BaseRepository;

class AdvertisementRepository extends BaseRepository
{
    public function __construct(Advertisement $model)
    {
        parent::__construct($model);
    }
}
