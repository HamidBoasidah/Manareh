<?php

namespace App\DTOs;

use App\Models\Notification;

class NotificationDTO extends BaseDTO
{
    public $id;
    public $recipient_type;
    public $recipient_id;
    public $channel;
    public $template_id;
    public $payload;
    public $status;
    public $sent_at;
    public $error;
    public $is_active;
    public $template_subject;

    public function __construct($id, $recipient_type = null, $recipient_id = null, $channel = null, $template_id = null, $payload = null, $status = null, $sent_at = null, $error = null, $template_subject = null)
    {
        $this->id = $id;
        $this->recipient_type = $recipient_type;
        $this->recipient_id = $recipient_id;
        $this->channel = $channel;
        $this->template_id = $template_id;
        $this->payload = $payload;
        $this->status = $status;
        $this->sent_at = $sent_at;
        $this->error = $error;
        $this->template_subject = $template_subject;
    }

    public static function fromModel(Notification $m): self
    {
        return new self(
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
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'recipient_type' => $this->recipient_type,
            'recipient_id' => $this->recipient_id,
            'channel' => $this->channel,
            'template_id' => $this->template_id,
            'payload' => $this->payload,
            'status' => $this->status,
            'sent_at' => $this->sent_at,
            'error' => $this->error,
            'template_subject' => $this->template_subject,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'recipient_type' => $this->recipient_type,
            'recipient_id' => $this->recipient_id,
            'status' => $this->status,
        ];
    }
}
