<?php

namespace App\DTOs;

use App\Models\StaffAssignment;

class StaffAssignmentDTO extends BaseDTO
{
    public $id;
    public $user_id;
    public $user_name;
    public $circle_id;
    public $circle_name;
    public $role_in_circle;
    public $start_at;
    public $end_at;
    public $notes;
    public $is_active;

    public function __construct(
        $id,
        $user_id,
        $user_name,
        $circle_id,
        $circle_name,
        $role_in_circle,
        $start_at,
        $end_at,
        $notes,
        $is_active
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->circle_id = $circle_id;
        $this->circle_name = $circle_name;
        $this->role_in_circle = $role_in_circle;
        $this->start_at = $start_at;
        $this->end_at = $end_at;
        $this->notes = $notes;
        $this->is_active = $is_active;
    }

    public static function fromModel(StaffAssignment $assignment): self
    {
        // ensure related user and circle are loaded minimally
        $assignment->loadMissing([
            'user:id,name',
            'circle:id,name',
        ]);

        return new self(
            $assignment->id,
            $assignment->user_id,
            $assignment->user?->name ?? null,
            $assignment->circle_id,
            $assignment->circle?->name ?? null,
            $assignment->role_in_circle,
            optional($assignment->start_at)->toDateTimeString(),
            optional($assignment->end_at)->toDateTimeString(),
            $assignment->notes,
            $assignment->is_active,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'circle_id' => $this->circle_id,
            'circle_name' => $this->circle_name,
            'role_in_circle' => $this->role_in_circle,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user_name,
            'circle_name' => $this->circle_name,
            'role_in_circle' => $this->role_in_circle,
            'is_active' => $this->is_active,
        ];
    }

    public static function tiny(\App\Models\StaffAssignment $s): array
    {
        return [
            'id' => $s->id,
            'user_name' => $s->user?->name,
        ];
    }

}
