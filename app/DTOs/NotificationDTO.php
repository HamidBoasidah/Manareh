<?php

namespace App\DTOs;

use App\Models\Notification;
use Illuminate\Support\Str;

class NotificationDTO extends BaseDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $channel,
        public readonly ?string $subject,
        public readonly ?string $body,
        public readonly ?array $payload,
        public readonly string $status,
        public readonly ?string $templateCode,
        public readonly ?string $sentAt,
        public readonly ?string $readAt,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
        public readonly ?string $shortBody,
        public readonly ?string $createdAtHuman,
    ) {
    }

    public static function fromModel(Notification $notification): self
    {
        $subject = $notification->subject ?? $notification->template?->renderSubject();
        $body = $notification->body ?? $notification->template?->renderBody();
        $createdAt = $notification->created_at;

        return new self(
            id: (int) $notification->id,
            channel: $notification->channel,
            subject: $subject,
            body: $body,
            payload: $notification->payload ?? null,
            status: $notification->status,
            templateCode: $notification->template?->code,
            sentAt: optional($notification->sent_at)->toIso8601String(),
            readAt: optional($notification->read_at)->toIso8601String(),
            createdAt: optional($createdAt)->toIso8601String(),
            updatedAt: optional($notification->updated_at)->toIso8601String(),
            shortBody: $body ? Str::limit(strip_tags((string) $body), 120) : null,
            createdAtHuman: optional($createdAt)?->diffForHumans(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'channel' => $this->channel,
            'subject' => $this->subject,
            'body' => $this->body,
            'payload' => $this->payload,
            'status' => $this->status,
            'template_code' => $this->templateCode,
            'sent_at' => $this->sentAt,
            'read_at' => $this->readAt,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'is_read' => (bool) $this->readAt,
            'short_body' => $this->shortBody,
            'created_at_human' => $this->createdAtHuman,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'channel' => $this->channel,
            'subject' => $this->subject,
            'short_body' => $this->shortBody,
            'status' => $this->status,
            'sent_at' => $this->sentAt,
            'read_at' => $this->readAt,
            'is_read' => (bool) $this->readAt,
            'created_at' => $this->createdAt,
            'created_at_human' => $this->createdAtHuman,
        ];
    }
}
