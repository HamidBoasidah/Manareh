<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationService
{
    protected NotificationRepository $notifications;

    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }

    /* --------------------------------
     * CRUD عام (لو حبيت تستخدمه إداريًا)
     * -------------------------------- */

    public function all(array $with = [])
    {
        return $this->notifications->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->notifications->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->notifications->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->notifications->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->notifications->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->notifications->delete($id);
    }

    public function activate($id)
    {
        return $this->notifications->activate($id);
    }

    public function deactivate($id)
    {
        return $this->notifications->deactivate($id);
    }

    /* --------------------------------
     * دوال خاصة بصندوق الوارد
     * -------------------------------- */

    /**
     * إرجاع Inbox المستخدم (قناة inbox فقط)
     * مع ترتيب الأحدث أولاً.
     */
    public function inboxForUser(int $userId, int $perPage = 15, array $with = [])
    {
        $query = $this->notifications
            ->builder($with)
            ->where('user_id', $userId)
            ->where('channel', 'inbox')
            ->orderByDesc('created_at');

        return $query->paginate($perPage);
    }

    /**
     * عدد الرسائل غير المقروءة للمستخدم في قناة inbox.
     */
    public function unreadCountForUser(int $userId): int
    {
        return $this->notifications
            ->builder()
            ->where('user_id', $userId)
            ->where('channel', 'inbox')
            ->whereNull('read_at')
            ->count();
    }

    /**
     * تعليم رسالة واحدة كمقروءة.
     */
    public function markAsRead(int $id)
    {
        return DB::transaction(function () use ($id) {
            $notification = $this->notifications->findOrFail($id);

            if (is_null($notification->read_at)) {
                $notification->read_at = Carbon::now();
                $notification->save();
            }

            return $notification;
        });
    }

    /**
     * تعليم جميع رسائل المستخدم كمقروءة في inbox.
     */
    public function markAllAsReadForUser(int $userId): int
    {
        return DB::transaction(function () use ($userId) {
            return $this->notifications
                ->builder()
                ->where('user_id', $userId)
                ->where('channel', 'inbox')
                ->whereNull('read_at')
                ->update(['read_at' => Carbon::now()]);
        });
    }
}
