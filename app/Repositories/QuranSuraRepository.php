<?php

namespace App\Repositories;

use App\Models\QuranSura;
use App\Repositories\Eloquent\BaseRepository;

class QuranSuraRepository extends BaseRepository
{
    public function __construct(QuranSura $model)
    {
        parent::__construct($model);
    }

    public function all(array $with = [])
    {
        return $this->query()->with($with)->orderBy('id')->get();
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->query()->with($with)->orderBy('id')->paginate($perPage);
    }
}
