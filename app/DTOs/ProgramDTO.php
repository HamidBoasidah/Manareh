<?php

namespace App\DTOs;

use App\Models\Program;

class ProgramDTO extends BaseDTO
{
    public $id;
    public $name;
    public $mosque_id;
    public $mosque_name;
    public $type;
    public $description;
    public $is_active;

    public function __construct(
        $id,
        $name = null,
        $mosque_id = null,
        $mosque_name = null,
        $type = null,
        $description = null,
        $is_active = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->mosque_id = $mosque_id;
        $this->mosque_name = $mosque_name;
        $this->type = $type;
        $this->description = $description;
        $this->is_active = $is_active;
    }

    public static function fromModel(Program $program): self
    {
        return new self(
            $program->id,
            $program->name,
            $program->mosque_id,
            $program->mosque?->name,
            $program->type,
            $program->description,
            $program->is_active,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mosque_id' => $this->mosque_id,
            'mosque_name' => $this->mosque_name,
            'type' => $this->type,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'mosque_name' => $this->mosque_name,
            'is_active' => $this->is_active,
        ];
    }
}
