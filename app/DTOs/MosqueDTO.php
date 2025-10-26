<?php

namespace App\DTOs;

use App\Models\Mosque;

class MosqueDTO extends BaseDTO
{
    public $id;
    public $name;
    public $city;
    public $address;
    public $phone;
    public $notes;
    public $is_active;

    public function __construct($id, $name, $city, $address, $phone, $notes, $is_active)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->address = $address;
        $this->phone = $phone;
        $this->notes = $notes;
        $this->is_active = $is_active;
    }

    public static function fromModel(Mosque $m): self
    {
        return new self(
            $m->id,
            $m->name,
            $m->city,
            $m->address,
            $m->phone,
            $m->notes,
            $m->is_active ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'address' => $this->address,
            'phone' => $this->phone,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
        ];
    }
}
