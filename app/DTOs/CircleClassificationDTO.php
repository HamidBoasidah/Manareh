<?php

namespace App\DTOs;

use App\Models\CircleClassification;

class CircleClassificationDTO extends BaseDTO
{
    public $id;
    public $name;
    public $is_active;
    
    public function __construct($id, $name, $is_active)
    {
        $this->id = $id;
        $this->name = $name;
        $this->is_active = (bool) $is_active;
    }

    public static function fromModel(CircleClassification $m): self
    {
        return new self(
            $m->id,
            $m->name,
            $m->is_active
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
        ];
    }
}
