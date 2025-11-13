<?php

namespace App\Events;

use App\Events\Contracts\NotifiesUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractNotificationEvent implements NotifiesUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        protected int $userId,
        protected string $templateCode,
        protected array $variables = [],
        protected array $payload = [],
        protected ?int $mosqueId = null,
        protected string $channel = 'inbox',
        protected ?string $locale = 'ar'
    ) {
    }

    public function getNotificationUserId(): int
    {
        return $this->userId;
    }

    public function getNotificationTemplateCode(): string
    {
        return $this->templateCode;
    }

    public function getNotificationVariables(): array
    {
        return $this->variables;
    }

    public function getNotificationPayload(): array
    {
        return $this->payload;
    }

    public function getNotificationMosqueId(): ?int
    {
        return $this->mosqueId;
    }

    public function getNotificationChannel(): string
    {
        return $this->channel;
    }

    public function getNotificationLocale(): ?string
    {
        return $this->locale;
    }
}
