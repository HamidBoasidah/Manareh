<?php

namespace App\DTOs;

use App\Models\Plan;

class PlanDTO extends BaseDTO
{
    public $id;
    // Plan model currently has no fillable defined; include common fields
    public $name;
    public $mosque_id;
    public $program_id;
    public $notes;
    public $is_active;
    
    public function __construct($id, $name = null, $mosque_id = null, $program_id = null, $notes = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->mosque_id = $mosque_id;
        $this->program_id = $program_id;
        $this->notes = $notes;
    }

    public static function fromModel(Plan $m): self
    {
        return new self(
            $m->id,
            $m->name ?? null,
            $m->mosque_id ?? null,
            $m->program_id ?? null,
            $m->notes ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mosque_id' => $this->mosque_id,
            'program_id' => $this->program_id,
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
