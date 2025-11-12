<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use App\Services\MessageTemplateService;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class NotificationService
{
    protected NotificationRepository $notifications;
    protected MessageTemplateService $templates;

    public function __construct(
        NotificationRepository $notifications,
        MessageTemplateService $templates
    ) {
        $this->notifications = $notifications;
        $this->templates = $templates;
    }

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

    /**
     * إنشاء إشعار باستخدام قالب.
     *
     * @param string $templateCode كود القالب (مثال: STUDENT_ADDED_TO_CIRCLE)
     * @param int    $userId      صاحب صندوق الوارد (users.id)
     * @param string $recipientType نوع الكيان (student/guardian/user...) اختياري
     * @param int    $recipientId   id الكيان (students.id مثلاً) اختياري
     * @param int    $mosqueId      المسجد المرتبط بالقالب
     * @param array  $payload       بيانات المتغيرات
     * @param string $locale        اللغة (افتراضي ar)
     */
    public function sendUsingTemplate(
        string $templateCode,
        int $userId,
        ?string $recipientType,
        ?int $recipientId,
        int $mosqueId,
        array $payload = [],
        string $locale = 'ar'
    ) {
        return DB::transaction(function () use (
            $templateCode,
            $userId,
            $recipientType,
            $recipientId,
            $mosqueId,
            $payload,
            $locale
        ) {
            $template = $this->templates->findByCode($templateCode, $mosqueId, $locale);

            if (! $template || ! $template->is_active) {
                throw new RuntimeException("Message template not found or inactive: {$templateCode}");
            }

            $subject = $template->renderSubject($payload);
            $body    = $template->renderBody($payload);

            return $this->notifications->create([
                'user_id'        => $userId,
                'recipient_type' => $recipientType,
                'recipient_id'   => $recipientId,
                'channel'        => $template->channel ?? 'inbox',
                'template_id'    => $template->id,
                'subject'        => $subject,
                'body'           => $body,
                'payload'        => $payload,
                'status'         => 'sent',
                'sent_at'        => now(),
                'is_active'      => true,
            ]);
        });
    }

    /* صندوق الوارد للمستخدم (للاستخدام في InboxController) */

    public function inboxForUser(int $userId, int $perPage = 15, array $with = [])
    {
        return $this->notifications->builder($with)
            ->where('user_id', $userId)
            ->where('channel', 'inbox')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function unreadCountForUser(int $userId): int
    {
        return $this->notifications->builder()
            ->where('user_id', $userId)
            ->where('channel', 'inbox')
            ->whereNull('read_at')
            ->count();
    }

    public function markAsRead(int $id, int $userId)
    {
        $n = $this->notifications->findOrFail($id);
    
        // تأكد أن الإشعار يخص هذا المستخدم
        if ($n->user_id !== $userId) {
            abort(403);
        }
    
        if (is_null($n->read_at)) {
            $n->read_at = now();
            $n->save();
        }
    
        return $n;
    }


    public function markAllAsReadForUser(int $userId): int
    {
        return $this->notifications->builder()
            ->where('user_id', $userId)
            ->where('channel', 'inbox')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
