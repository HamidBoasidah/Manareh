<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Eloquent\BaseRepository;

class NotificationRepository extends BaseRepository
{
    protected array $defaultWith = [
        'user:id,name',
        'template:id,code,channel,locale,subject',
    ];

    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }
}
