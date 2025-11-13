<?php

namespace App\Services;

use App\DTOs\NotificationDTO;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function __construct(
        protected NotificationRepository $notifications,
        protected MessageTemplateService $templates,
    ) {
    }

    public function paginateForUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        $paginator = $this->notifications->paginateForUser($userId, $perPage);

        return $this->mapPaginator($paginator, fn (Notification $notification) => NotificationDTO::fromModel($notification)->toIndexArray());
    }

    public function getForUser(int $userId, int $notificationId): NotificationDTO
    {
        $notification = $this->notifications->findForUser($userId, $notificationId);
        return NotificationDTO::fromModel($notification);
    }

    public function markAsRead(int $userId, int $notificationId): void
    {
        $this->notifications->markAsRead($userId, [$notificationId]);
    }

    public function markAsUnread(int $userId, int $notificationId): void
    {
        $this->notifications->markAsUnread($userId, [$notificationId]);
    }

    public function markAllAsRead(int $userId): void
    {
        $this->notifications->markAllAsRead($userId);
    }

    public function markAllAsUnread(int $userId): void
    {
        $this->notifications->markAllAsUnread($userId);
    }

    public function paginateForAdmin(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->notifications->builder();

        if ($userId = $filters['user_id'] ?? null) {
            $query->where('user_id', $userId);
        }

        if ($channel = $filters['channel'] ?? null) {
            $query->where('channel', $channel);
        }

        if ($status = $filters['status'] ?? null) {
            $query->where('status', $status);
        }

        if (! empty($filters['unread_only'])) {
            $query->whereNull('read_at');
        }

        $paginator = $query->paginate($perPage);

        return $this->mapPaginator($paginator, function (Notification $notification) {
            $base = NotificationDTO::fromModel($notification)->toIndexArray();
            $base['user'] = [
                'id' => $notification->user?->id,
                'name' => $notification->user?->name,
            ];

            return $base;
        });
    }

    public function getById(int $notificationId): array
    {
        $notification = $this->notifications->findOrFail($notificationId, ['user:id,name']);
        $dto = NotificationDTO::fromModel($notification)->toArray();
        $dto['user'] = [
            'id' => $notification->user?->id,
            'name' => $notification->user?->name,
        ];

        return $dto;
    }

    public function delete(int $notificationId): void
    {
        $this->notifications->delete($notificationId);
    }

    public function createManual(array $attributes): NotificationDTO
    {
        $notification = $this->notifications->createNotification($attributes);
        $notification->loadMissing(['template', 'user:id,name']);

        return NotificationDTO::fromModel($notification);
    }

    public function createFromTemplate(
        int $userId,
        string $templateCode,
        ?int $mosqueId,
        array $placeholders = [],
        array $payload = [],
        string $channel = 'inbox',
        ?string $locale = 'ar'
    ): ?NotificationDTO {
        $rendered = $this->templates->renderTemplate($templateCode, $mosqueId, $placeholders, $locale, $channel);

        if (! $rendered) {
            Log::warning('Missing message template', [
                'code' => $templateCode,
                'mosque_id' => $mosqueId,
                'channel' => $channel,
                'locale' => $locale,
            ]);

            $rendered = [
                'subject' => $this->fallbackSubject($templateCode),
                'body' => $this->fallbackBody($templateCode, $placeholders),
                'template' => null,
            ];
        }

        $data = [
            'user_id' => $userId,
            'template_id' => $rendered['template']?->id,
            'channel' => $channel,
            'subject' => $rendered['subject'],
            'body' => $rendered['body'],
            'payload' => $payload,
            'status' => 'sent',
            'sent_at' => now(),
        ];

        $notification = $this->notifications->createNotification($data);

        if ($rendered['template']) {
            $notification->setRelation('template', $rendered['template']);
        }

        $notification->loadMissing('user:id,name');

        return NotificationDTO::fromModel($notification);
    }

    private function fallbackSubject(string $templateCode): string
    {
        return 'إشعار النظام: ' . $templateCode;
    }

    private function fallbackBody(string $templateCode, array $placeholders): string
    {
        $lines = ['لا يوجد قالب مسجل لهذا الإشعار (' . $templateCode . ').'];

        if (! empty($placeholders)) {
            $lines[] = json_encode($placeholders, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return implode("\n\n", $lines);
    }

    private function mapPaginator(LengthAwarePaginator $paginator, callable $callback): LengthAwarePaginator
    {
        $collection = $paginator->getCollection()->map($callback);
        $paginator->setCollection($collection);

        return $paginator;
    }
}
