<?php

namespace App\DTOs;

use App\Models\Program;

class ProgramDTO extends BaseDTO
{
    public $id;
    public $name;
    public $mosque_id;
    public $notes;
    public $is_active;

    public function __construct($id, $name = null, $mosque_id = null, $notes = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->mosque_id = $mosque_id;
        $this->notes = $notes;
    }

    public static function fromModel(Program $m): self
    {
        return new self(
            $m->id,
            $m->name ?? null,
            $m->mosque_id ?? null,
            $m->notes ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mosque_id' => $this->mosque_id,
            'notes' => $this->notes,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active ?? null,
        ];
    }
}
