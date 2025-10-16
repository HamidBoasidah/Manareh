<?php

namespace App\DTOs;

use App\Models\User;

class UserDTO
{
    public $id;
    public $name;
    public $email;
    public $address;
    public $phone_number;
    public $whatsapp_number;
    public $is_active;
    public $attachment;
    public $medical_facility;
    public $role;
    public $medical_facility_id;
    public $role_id;

    public function __construct($id, $name, $email, $address, $phone_number, $whatsapp_number, $is_active, $attachment, $medical_facility, $role, $medical_facility_id, $role_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->phone_number = $phone_number;
        $this->whatsapp_number = $whatsapp_number;
        $this->is_active = $is_active;
        $this->attachment = $attachment;
        $this->medical_facility = $medical_facility;
        $this->role = $role;
        $this->medical_facility_id = $medical_facility_id;
        $this->role_id = $role_id;
    }

    public static function fromModel(User $user): self
    {
        $user->load(['medicalFacility', 'roles']);
        $role = $user->roles->first();
        return new self(
            $user->id,
            $user->name,
            $user->email,
            $user->address,
            $user->phone_number,
            $user->whatsapp_number,
            $user->is_active,
            $user->attachment,
            $user->medicalFacility ? [
                'id' => $user->medicalFacility->id,
                'name_ar' => $user->medicalFacility->name_ar,
                'name_en' => $user->medicalFacility->name_en,
                'display_name' => [
                    'ar' => $user->medicalFacility->name_ar,
                    'en' => $user->medicalFacility->name_en,
                ],
            ] : null,
            $role ? [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->getTranslations('display_name'),
            ] : null,
            $user->medicalFacility?->id,
            $role?->id
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'is_active' => $this->is_active,
            'attachment' => $this->attachment,
            'medical_facility' => $this->medical_facility,
            'role' => $this->role,
            'medical_facility_id' => $this->medical_facility_id,
            'role_id' => $this->role_id,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'is_active' => $this->is_active,
            'attachment' => $this->attachment,
            'role' => $this->role,
        ];
    }
}
