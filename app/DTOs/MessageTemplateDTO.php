<?php

namespace App\DTOs;

use App\Models\MessageTemplate;

class MessageTemplateDTO extends BaseDTO
{
    public $id;
    public $mosque_id;
    public $code;
    public $channel;
    public $locale;
    public $subject;
    public $body;
    public $description;
    public $is_active;
    public $rendered_subject;
    public $rendered_body;

    public function __construct(
        $id,
        $mosque_id = null,
        $code = null,
        $channel = null,
        $locale = null,
        $subject = null,
        $body = null,
        $description = null,
        $is_active = null,
        $rendered_subject = null,
        $rendered_body = null
    ) {
        $this->id = $id;
        $this->mosque_id = $mosque_id;
        $this->code = $code;
        $this->channel = $channel;
        $this->locale = $locale;
        $this->subject = $subject;
        $this->body = $body;
        $this->description = $description;
        $this->is_active = $is_active;
        $this->rendered_subject = $rendered_subject;
        $this->rendered_body = $rendered_body;
    }

    public static function fromModel(MessageTemplate $m, array $payload = []): self
    {
        return new self(
            $m->id,
            $m->mosque_id,
            $m->code,
            $m->channel,
            $m->locale ?? 'ar',
            $m->subject,
            $m->body,
            $m->description,
            $m->is_active,
            // ✅ معاينة النصوص بعد استبدال المتغيرات
            $m->renderSubject($payload),
            $m->renderBody($payload)
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mosque_id' => $this->mosque_id,
            'code' => $this->code,
            'channel' => $this->channel,
            'locale' => $this->locale,
            'subject' => $this->subject,
            'body' => $this->body,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'rendered_subject' => $this->rendered_subject,
            'rendered_body' => $this->rendered_body,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'channel' => $this->channel,
            'locale' => $this->locale,
            'subject' => $this->subject,
            'is_active' => $this->is_active,
        ];
    }
}
