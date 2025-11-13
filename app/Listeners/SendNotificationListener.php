<?php

namespace App\Listeners;

use App\Events\Contracts\NotifiesUser;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class SendNotificationListener
{

    public function __construct(private NotificationService $notifications)
    {
    }

    public function handle(NotifiesUser $event): void
    {
        $dto = $this->notifications->createFromTemplate(
            userId: $event->getNotificationUserId(),
            templateCode: $event->getNotificationTemplateCode(),
            mosqueId: $event->getNotificationMosqueId(),
            placeholders: $event->getNotificationVariables(),
            payload: $event->getNotificationPayload(),
            channel: $event->getNotificationChannel(),
            locale: $event->getNotificationLocale()
        );

        if (! $dto) {
            Log::warning('Notification not created from event', [
                'event' => get_class($event),
                'user_id' => $event->getNotificationUserId(),
                'template' => $event->getNotificationTemplateCode(),
            ]);
        }
    }
}
