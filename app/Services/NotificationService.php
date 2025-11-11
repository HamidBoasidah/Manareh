<?php

namespace App\Services;

use App\Models\Notification;
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
        return DB::transaction(function () use ($attributes) {
            // إذا كان عندنا code للقالب نستخدمه لتوليد نص الإشعار
            if (isset($attributes['template_code']) && isset($attributes['mosque_id'])) {
                $payload = $attributes['payload'] ?? [];
                $locale = $attributes['locale'] ?? 'ar';
                $templateData = $this->templates->renderTemplate(
                    $attributes['template_code'],
                    $attributes['mosque_id'],
                    $payload,
                    $locale
                );

                if (! $templateData) {
                    throw new RuntimeException("Template not found for code: {$attributes['template_code']}");
                }

                $attributes['subject'] = $templateData['subject'];
                $attributes['body'] = $templateData['body'];

                // استرجع ID القالب نفسه
                $template = $this->templates->findByCode($attributes['template_code'], $attributes['mosque_id']);
                $attributes['template_id'] = $template?->id;
            }

            return $this->notifications->create($attributes);
        });
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
     * 🔹 واجهة مختصرة: إنشاء إشعار من كود القالب مباشرة.
     *
     * @param string $templateCode مثال: 'STUDENT_ADDED_TO_CIRCLE'
     * @param string $recipientType مثال: 'student'
     * @param int $recipientId
     * @param int $mosqueId
     * @param array $payload بيانات المتغيرات
     */
    public function sendUsingTemplate(string $templateCode, string $recipientType, int $recipientId, int $mosqueId, array $payload = [])
    {
        return $this->create([
            'recipient_type' => $recipientType,
            'recipient_id'   => $recipientId,
            'mosque_id'      => $mosqueId,
            'template_code'  => $templateCode,
            'payload'        => $payload,
            'channel'        => 'inbox',
            'status'         => 'queued',
        ]);
    }
}
