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
        $user = \App\Models\User::find($userId);
        if (! $user) {
            return $this->model->newQuery()->whereRaw('1 = 0')->paginate(0);
        }
        $query = $this->builder($with)->where(function (Builder $q) use ($user) {
            $q->where('user_id', $user->getKey())
                ->orWhere(function (Builder $q2) use ($user) {
                    $q2->where('recipient_type', 'user')
                        ->where('recipient_id', $user->getKey());
                });

            // include global broadcasts only for full-access users
            if ($user->hasAnyRole(['super-admin', 'admin', 'manager'])) {
                $q->orWhere(function (Builder $q3) {
                    $q3->whereNull('recipient_type')->orWhere('recipient_type', 'all');
                });
            }
        });

        return $query->paginate($perPage);
    }

    public function findForUser(int $userId, int $notificationId, array $with = []): Notification
    {
        $user = \App\Models\User::find($userId);
        if (! $user) {
            abort(404);
        }
        $query = $this->builder($with)->where(function (Builder $q) use ($user) {
            $q->where('user_id', $user->getKey())
                ->orWhere(function (Builder $q2) use ($user) {
                    $q2->where('recipient_type', 'user')
                        ->where('recipient_id', $user->getKey());
                });

            if ($user->hasAnyRole(['super-admin', 'admin', 'manager'])) {
                $q->orWhere(function (Builder $q3) {
                    $q3->whereNull('recipient_type')->orWhere('recipient_type', 'all');
                });
            }
        });

        return $query->findOrFail($notificationId);
    }

    public function markAsRead(int $userId, array $notificationIds): int
    {
        return $this->model->newQuery()
            ->where(function (Builder $q) use ($userId) {
                $q->where('user_id', $userId)
                    ->orWhere(function (Builder $q2) use ($userId) {
                        $q2->where('recipient_type', 'user')
                            ->where('recipient_id', $userId);
                    });
            })
            ->whereIn('id', $notificationIds)
            ->update(['read_at' => now()]);
    }

    public function markAsUnread(int $userId, array $notificationIds): int
    {
        return $this->model->newQuery()
            ->where(function (Builder $q) use ($userId) {
                $q->where('user_id', $userId)
                    ->orWhere(function (Builder $q2) use ($userId) {
                        $q2->where('recipient_type', 'user')
                            ->where('recipient_id', $userId);
                    });
            })
            ->whereIn('id', $notificationIds)
            ->update(['read_at' => null]);
    }

    public function markAllAsRead(int $userId): int
    {
        return $this->model->newQuery()
            ->where(function (Builder $q) use ($userId) {
                $q->where('user_id', $userId)
                    ->orWhere(function (Builder $q2) use ($userId) {
                        $q2->where('recipient_type', 'user')
                            ->where('recipient_id', $userId);
                    });
            })
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function markAllAsUnread(int $userId): int
    {
        return $this->model->newQuery()
            ->where(function (Builder $q) use ($userId) {
                $q->where('user_id', $userId)
                    ->orWhere(function (Builder $q2) use ($userId) {
                        $q2->where('recipient_type', 'user')
                            ->where('recipient_id', $userId);
                    });
            })
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
