<?php

namespace App\DTOs;

use App\Models\Notification;

class NotificationDTO extends BaseDTO
{
    public $id;
    public $user_id;
    public $recipient_type;
    public $recipient_id;
    public $channel;
    public $template_id;
    public $subject;
    public $body;
    public $payload;
    public $status;
    public $sent_at;
    public $read_at;
    public $error;
    public $is_active;
    public $is_read;
    public $short_body;
    public $status_label;
    public $template_subject;

    public function __construct(
        $id,
        $user_id = null,
        $recipient_type = null,
        $recipient_id = null,
        $channel = null,
        $template_id = null,
        $subject = null,
        $body = null,
        $payload = null,
        $status = null,
        $sent_at = null,
        $read_at = null,
        $error = null,
        $is_active = null,
        $is_read = null,
        $short_body = null,
        $status_label = null,
        $template_subject = null
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->recipient_type = $recipient_type;
        $this->recipient_id = $recipient_id;
        $this->channel = $channel;
        $this->template_id = $template_id;
        $this->subject = $subject;
        $this->body = $body;
        $this->payload = $payload;
        $this->status = $status;
        $this->sent_at = $sent_at;
        $this->read_at = $read_at;
        $this->error = $error;
        $this->is_active = $is_active;
        $this->is_read = $is_read;
        $this->short_body = $short_body;
        $this->status_label = $status_label;
        $this->template_subject = $template_subject;
    }

    public static function fromModel(Notification $m): self
    {
        return new self(
            $m->id,
            $m->user_id,
            $m->recipient_type,
            $m->recipient_id,
            $m->channel,
            $m->template_id,
            $m->subject,
            $m->body,
            $m->payload,
            $m->status,
            $m->sent_at,
            $m->read_at,
            $m->error,
            $m->is_active,
            $m->is_read,
            $m->short_body,
            $m->status_label,
            $m->template?->subject
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'recipient_type' => $this->recipient_type,
            'recipient_id' => $this->recipient_id,
            'channel' => $this->channel,
            'template_id' => $this->template_id,
            'subject' => $this->subject,
            'body' => $this->body,
            'payload' => $this->payload,
            'status' => $this->status,
            'sent_at' => $this->sent_at,
            'read_at' => $this->read_at,
            'error' => $this->error,
            'is_active' => $this->is_active,
            'is_read' => $this->is_read,
            'short_body' => $this->short_body,
            'status_label' => $this->status_label,
            'template_subject' => $this->template_subject,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'short_body' => $this->short_body,
            'is_read' => $this->is_read,
            'status_label' => $this->status_label,
            'sent_at' => $this->sent_at,
        ];
    }
}
