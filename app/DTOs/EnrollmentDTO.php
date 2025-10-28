<?php

namespace App\DTOs;

use App\Models\Enrollment;

class EnrollmentDTO extends BaseDTO
{
    public $id;
    public $circle_id;
    public $student_id;
    public $status;
    public $joined_at;
    public $left_at;
    public $is_active;
    public $circle_name;
    public $student_name;
    public $student_phone;

    public function __construct(
        $id,
        $circle_id,
        $student_id,
        $status,
        $joined_at,
        $left_at,
        $is_active,
        $circle_name = null,
        $student_name = null,
        $student_phone = null
    ) {
        $this->id = $id;
        $this->circle_id = $circle_id;
        $this->student_id = $student_id;
        $this->status = $status;
        $this->joined_at = $joined_at;
        $this->left_at = $left_at;
        $this->is_active = $is_active;
        $this->circle_name = $circle_name;
        $this->student_name = $student_name;
        $this->student_phone = $student_phone;
    }

    public static function fromModel(Enrollment $enrollment): self
    {
        return new self(
            $enrollment->id,
            $enrollment->circle_id,
            $enrollment->student_id,
            $enrollment->status,
            $enrollment->joined_at,
            $enrollment->left_at,
            $enrollment->is_active,
            $enrollment->circle?->name ?? null,
            $enrollment->student?->user?->name ?? null,
            // prefer phone on the related user record (users.phone_number), fallback to student.phone_number
            $enrollment->student?->user?->phone_number ?? $enrollment->student?->phone_number ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'circle_id' => $this->circle_id,
            'student_id' => $this->student_id,
            'status' => $this->status,
            'joined_at' => $this->joined_at,
            'left_at' => $this->left_at,
            'is_active' => $this->is_active,
            'circle_name' => $this->circle_name,
            'student_name' => $this->student_name,
            'student_phone' => $this->student_phone,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'circle_name' => $this->circle_name,
            'student_name' => $this->student_name,
            'status' => $this->status,
            'joined_at' => $this->joined_at,
            'is_active' => $this->is_active,
        ];
    }
}
