<?php

namespace App\DTOs;

use App\Models\MessageTemplate;

class MessageTemplateDTO extends BaseDTO
{
    public $id;
    public $mosque_id;
    public $code;
    public $channel;
    public $subject;
    public $body;
    public $is_active;

    public function __construct($id, $mosque_id = null, $code = null, $channel = null, $subject = null, $body = null)
    {
        $this->id = $id;
        $this->mosque_id = $mosque_id;
        $this->code = $code;
        $this->channel = $channel;
        $this->subject = $subject;
        $this->body = $body;
    }

    public static function fromModel(MessageTemplate $m): self
    {
        return new self(
            $m->id,
            $m->mosque_id ?? null,
            $m->code ?? null,
            $m->channel ?? null,
            $m->subject ?? null,
            $m->body ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mosque_id' => $this->mosque_id,
            'code' => $this->code,
            'channel' => $this->channel,
            'subject' => $this->subject,
            'body' => $this->body,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'is_active' => $this->is_active ?? null,
        ];
    }
}
