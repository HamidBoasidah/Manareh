<?php

namespace App\DTOs;

use App\Models\Student;

class StudentDTO extends BaseDTO
{
    public $id;
    public $user_id;
    public $mosque_id;
    public $guardian_id;
    public $birth_date;
    public $address;
    public $phone_number;
    public $whatsapp_number;
    public $nationality;
    public $notes;
    public $is_active;
    public $user_name;
    public $user_email;
    public $guardian_name;
    public $guardian_phone;
    public $mosque_name;

    public function __construct(
        $id,
        $user_id,
        $mosque_id,
        $guardian_id,
        $birth_date,
        $address,
        $phone_number,
        $whatsapp_number,
        $nationality,
        $notes,
        $is_active,
        $user_name = null,
        $user_email = null,
        $guardian_name = null,
        $guardian_phone = null,
        $mosque_name = null
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->mosque_id = $mosque_id;
        $this->guardian_id = $guardian_id;
        $this->birth_date = $birth_date;
        $this->address = $address;
        $this->phone_number = $phone_number;
        $this->whatsapp_number = $whatsapp_number;
        $this->nationality = $nationality;
        $this->notes = $notes;
        $this->is_active = $is_active;
        $this->user_name = $user_name;
        $this->user_email = $user_email;
        $this->guardian_name = $guardian_name;
        $this->guardian_phone = $guardian_phone;
        $this->mosque_name = $mosque_name;
    }

    public static function fromModel(Student $student): self
    {
        return new self(
            $student->id,
            $student->user_id,
            $student->mosque_id,
            $student->guardian_id,
            $student->birth_date,
            $student->address,
            $student->phone_number,
            $student->whatsapp_number,
            $student->nationality,
            $student->notes,
            $student->is_active,
            $student->user?->name,
            $student->user?->email,
            $student->guardian?->name,
            $student->guardian?->phone_number,
            $student->mosque?->name
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'mosque_id' => $this->mosque_id,
            'guardian_id' => $this->guardian_id,
            'birth_date' => $this->birth_date,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'nationality' => $this->nationality,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
            'guardian_name' => $this->guardian_name,
            'guardian_phone' => $this->guardian_phone,
            'mosque_name' => $this->mosque_name,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user_name,
            'email' => $this->user_email,
            'guardian_name' => $this->guardian_name,
            'guardian_phone' => $this->guardian_phone,
            'mosque_name' => $this->mosque_name,
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'address' => $this->address,
            'nationality' => $this->nationality,
            'is_active' => $this->is_active,
        ];
    }
}
