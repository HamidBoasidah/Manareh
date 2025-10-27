<?php

namespace App\DTOs;

use App\Models\Guardian;

class GuardianDTO extends BaseDTO
{
    public $id;
    public $name;
    public $phone_number;
    public $whatsapp_number;
    public $relation;
    public $is_active;

    public function __construct($id, $name, $phone_number = null, $whatsapp_number = null, $relation = null, $is_active = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone_number = $phone_number;
        $this->whatsapp_number = $whatsapp_number;
        $this->relation = $relation;
        $this->is_active = $is_active;
    }

    public static function fromModel(Guardian $g): self
    {
        return new self(
            $g->id,
            $g->name,
            $g->phone_number ?? null,
            $g->whatsapp_number ?? null,
            $g->relation ?? null,
            $g->is_active ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'relation' => $this->relation,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'relation' => $this->relation,
            'is_active' => $this->is_active,
        ];
    }
}
