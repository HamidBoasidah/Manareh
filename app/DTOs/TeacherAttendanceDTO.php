<?php

namespace App\DTOs;

use App\Models\TeacherAttendance;

class TeacherAttendanceDTO extends BaseDTO
{
    public $id;
    public $circle_id;
    public $user_id;
    public $date_g;
    public $date_h;
    public $status;
    public $notes;
    public $recorded_by;
    public $is_active;
    public $circle_name;
    public $user_name;
    public $user_role;
    public $recorded_by_name;

    public function __construct(
        $id,
        $circle_id,
        $user_id,
        $date_g,
        $date_h,
        $status,
        $notes,
        $recorded_by,
        $is_active,
        $circle_name = null,
        $user_name = null,
        $user_role = null,
        $recorded_by_name = null
    ) {
        $this->id = $id;
        $this->circle_id = $circle_id;
        $this->user_id = $user_id;
        $this->date_g = $date_g;
        $this->date_h = $date_h;
        $this->status = $status;
        $this->notes = $notes;
        $this->recorded_by = $recorded_by;
        $this->is_active = $is_active;
        $this->circle_name = $circle_name;
        $this->user_name = $user_name;
        $this->user_role = $user_role;
        $this->recorded_by_name = $recorded_by_name;
    }

    public static function fromModel(TeacherAttendance $m): self
    {
        $circle = $m->circle;
        $user = $m->user;
        $recordedBy = $m->recordedBy;

        $role = null;
        if ($user && method_exists($user, 'getRoleNames')) {
            $role = $user->getRoleNames()->first();
        }

        return new self(
            $m->id,
            $m->circle_id,
            $m->user_id,
            $m->date_g?->toDateString(),
            $m->date_h,
            $m->status,
            $m->notes,
            $m->recorded_by,
            $m->is_active,
            $circle?->name,
            $user?->name,
            $role,
            $recordedBy?->name
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'circle_id' => $this->circle_id,
            'user_id' => $this->user_id,
            'date_g' => $this->date_g,
            'date_h' => $this->date_h,
            'status' => $this->status,
            'notes' => $this->notes,
            'recorded_by' => $this->recorded_by,
            'is_active' => $this->is_active,
            'circle_name' => $this->circle_name,
            'user_name' => $this->user_name,
            'user_role' => $this->user_role,
            'recorded_by_name' => $this->recorded_by_name,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user_name,
            'user_role' => $this->user_role,
            'circle_name' => $this->circle_name,
            'date_g' => $this->date_g,
            'status' => $this->status,
            'is_active' => $this->is_active,
        ];
    }
}
