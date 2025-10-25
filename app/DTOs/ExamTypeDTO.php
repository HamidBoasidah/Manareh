<?php

namespace App\DTOs;

use App\Models\ExamType;

class ExamTypeDTO extends BaseDTO
{
    public $id;
    public $mosque_id;
    public $name;
    public $part_required;
    public $is_active;

    public function __construct($id, $mosque_id = null, $name = null, $part_required = null)
    {
        $this->id = $id;
        $this->mosque_id = $mosque_id;
        $this->name = $name;
        $this->part_required = $part_required;
    }

    public static function fromModel(ExamType $m): self
    {
        return new self(
            $m->id,
            $m->mosque_id ?? null,
            $m->name ?? null,
            $m->part_required ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mosque_id' => $this->mosque_id,
            'name' => $this->name,
            'part_required' => $this->part_required,
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
