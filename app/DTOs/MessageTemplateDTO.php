<?php

namespace App\DTOs;

use App\Models\MessageTemplate;

class MessageTemplateDTO extends BaseDTO
{
    public $id;
    public $mosque_id;
    public $mosque_name;
    public $code;
    public $name;
    public $channel;
    public $locale;
    public $subject;
    public $description;
    public $body;
    public $variables;
    public $sample_payload;
    public $extras;
    public $is_active;
    public $created_at;
    public $updated_at;
    public $created_by_name;
    public $updated_by_name;

    public static function fromModel(MessageTemplate $m): self
    {
        $dto = new self();

        $dto->id = $m->id;
        $dto->mosque_id = $m->mosque_id;
        $dto->mosque_name = optional($m->mosque)->name;
        $dto->code = $m->code;
        $dto->name = $m->name;
        $dto->channel = $m->channel;
        $dto->locale = $m->locale;
        $dto->subject = $m->subject;
        $dto->description = $m->description;
        $dto->body = $m->body;
        $dto->variables = $m->variables ?? [];
        $dto->sample_payload = $m->sample_payload ?? [];
        $dto->extras = $m->extras ?? [];
        $dto->is_active = (bool) $m->is_active;
        $dto->created_at = optional($m->created_at)->toDateTimeString();
        $dto->updated_at = optional($m->updated_at)->toDateTimeString();
        $dto->created_by_name = optional($m->creator)->name;
        $dto->updated_by_name = optional($m->updater)->name;

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mosque_id' => $this->mosque_id,
            'mosque_name' => $this->mosque_name,
            'code' => $this->code,
            'name' => $this->name,
            'channel' => $this->channel,
            'locale' => $this->locale,
            'subject' => $this->subject,
            'description' => $this->description,
            'body' => $this->body,
            'variables' => $this->variables,
            'sample_payload' => $this->sample_payload,
            'extras' => $this->extras,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by_name' => $this->created_by_name,
            'updated_by_name' => $this->updated_by_name,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'channel' => $this->channel,
            'locale' => $this->locale,
            'is_active' => $this->is_active ?? null,
            'updated_at' => $this->updated_at,
            'variables_count' => is_array($this->variables) ? count($this->variables) : 0,
        ];
    }
}
