<?php

namespace App\DTOs;

use App\Models\Circle;

class CircleDTO extends BaseDTO
{
    public $id;
    public $name;
    public $mosque_id;
    public $classification_id;
    public $capacity;
    public $notes;
    public $is_active;
    public $mosque_name;
    public $classification_name;

    public function __construct(
        $id,
        $name,
        $mosque_id,
        $classification_id,
        $capacity,
        $notes,
        $is_active,
        $mosque_name = null,
        $classification_name = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->mosque_id = $mosque_id;
        $this->classification_id = $classification_id;
        $this->capacity = $capacity;
        $this->notes = $notes;
        $this->is_active = $is_active;
        $this->mosque_name = $mosque_name;
        $this->classification_name = $classification_name;
    }

    public static function fromModel(Circle $circle): self
    {
        // لن يعيد التحميل إذا كانت محملة مسبقًا (idempotent)
        $circle->loadMissing([
            'mosque:id,name',
            'classification:id,name',
        ]);
        return new self(
            $circle->id,
            $circle->name,
            $circle->mosque_id,
            $circle->classification_id,
            $circle->capacity,
            $circle->notes,
            $circle->is_active,
            $circle->mosque?->name ?? null,
            $circle->classification?->name ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mosque_id' => $this->mosque_id,
            'classification_id' => $this->classification_id,
            'capacity' => $this->capacity,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'mosque_name' => $this->mosque_name,
            'classification_name' => $this->classification_name,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'capacity' => $this->capacity,
            'is_active' => $this->is_active,
            'mosque_name' => $this->mosque_name,
            'classification_name' => $this->classification_name,
        ];
    }
}
