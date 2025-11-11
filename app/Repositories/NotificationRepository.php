<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Eloquent\BaseRepository;

class NotificationRepository extends BaseRepository
{
    protected array $defaultWith = [
        'template:id,code,subject',
    ];

    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function unreadForUser(string $type, int $id)
    {
        return $this->model
            ->where('recipient_type', $type)
            ->where('recipient_id', $id)
            ->where('status', 'queued')
            ->latest()
            ->get();
    }
}
