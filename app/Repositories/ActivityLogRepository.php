<?php

namespace App\Repositories;

use Spatie\Activitylog\Models\Activity;
use App\Repositories\Eloquent\BaseRepository;

class ActivityLogRepository extends BaseRepository
{
    protected array $defaultWith = [
        'causer:id,name',
        'subject',
    ];

    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }
}
