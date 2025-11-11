<?php

namespace App\DTOs;

use App\Models\Notification;

class NotificationDTO extends BaseDTO
{
    public static function fromModel(Notification $m): self
    {
        $dto = new self(
            $m->id,
            $m->recipient_type,
            $m->recipient_id,
            $m->channel,
            $m->template_id,
            $m->payload,
            $m->status,
            $m->sent_at,
            $m->error,
            $m->template?->subject ?? null
        );

        // إضافات
        $dto->subject = $m->subject ?? $m->template?->subject;
        $dto->body = $m->body;
        $dto->short_body = $m->short_body;
        $dto->is_read = $m->is_read;
        $dto->created_at_human = $m->created_at_human;

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'id'                 => $this->id,
            'recipient_type'     => $this->recipient_type,
            'recipient_id'       => $this->recipient_id,
            'channel'            => $this->channel,
            'template_id'        => $this->template_id,
            'payload'            => $this->payload,
            'status'             => $this->status,
            'sent_at'            => $this->sent_at,
            'error'              => $this->error,
            'subject'            => $this->subject,
            'body'               => $this->body,
            'short_body'         => $this->short_body,
            'is_read'            => $this->is_read,
            'created_at_human'   => $this->created_at_human,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id'               => $this->id,
            'subject'          => $this->subject,
            'short_body'       => $this->short_body,
            'is_read'          => $this->is_read,
            'created_at_human' => $this->created_at_human,
        ];
    }
}
