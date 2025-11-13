<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationRepository extends BaseRepository
{
    protected array $defaultWith = [
        'template:id,code,subject,body',
        'user:id,name',
    ];

    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function builder(array $with = []): Builder
    {
        return parent::builder($with)->orderByDesc('sent_at')->orderByDesc('id');
    }

    public function paginateForUser(int $userId, int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return $this->builder($with)
            ->where('user_id', $userId)
            ->paginate($perPage);
    }

    public function findForUser(int $userId, int $notificationId, array $with = []): Notification
    {
        return $this->builder($with)
            ->where('user_id', $userId)
            ->findOrFail($notificationId);
    }

    public function markAsRead(int $userId, array $notificationIds): int
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->whereIn('id', $notificationIds)
            ->update(['read_at' => now()]);
    }

    public function markAsUnread(int $userId, array $notificationIds): int
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->whereIn('id', $notificationIds)
            ->update(['read_at' => null]);
    }

    public function markAllAsRead(int $userId): int
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function markAllAsUnread(int $userId): int
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->update(['read_at' => null]);
    }

    public function createNotification(array $attributes): Notification
    {
        $attributes = $this->prepareAttributes($attributes);
        return $this->create($attributes);
    }

    protected function prepareAttributes(array $attributes): array
    {
        $attributes['status'] = $attributes['status'] ?? 'sent';
        $attributes['sent_at'] = $attributes['sent_at'] ?? now();
        $attributes['payload'] = $attributes['payload'] ?? [];
        $attributes['channel'] = $attributes['channel'] ?? 'inbox';

        return $attributes;
    }
}
