<?php

namespace App\DTOs;

use App\Models\DailyStudy;

class DailyStudyDTO extends BaseDTO
{
    public function __construct(
        public int $id,
        public ?int $session_id = null,
        public ?int $student_id = null,
        public ?string $student_name = null,
        public ?int $hifz_from_sura_id = null,
        public ?int $hifz_from_ayah = null,
        public ?int $hifz_to_sura_id = null,
        public ?int $hifz_to_ayah = null,
        public ?int $hifz_pages = null,
        public ?int $murajaah_from_sura_id = null,
        public ?int $murajaah_from_ayah = null,
        public ?int $murajaah_to_sura_id = null,
        public ?int $murajaah_to_ayah = null,
        public ?int $murajaah_pages = null,
        public ?int $points = null,
        public ?string $attendance_status = null,
        public ?string $notes = null,
        public ?bool $is_active = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {
    }

    public static function fromModel(DailyStudy $dailyStudy): self
    {
        $student = $dailyStudy->student?->user;

        return new self(
            id: $dailyStudy->id,
            session_id: $dailyStudy->session_id,
            student_id: $dailyStudy->student_id,
            student_name: $student?->name,
            hifz_from_sura_id: $dailyStudy->hifz_from_sura_id,
            hifz_from_ayah: $dailyStudy->hifz_from_ayah,
            hifz_to_sura_id: $dailyStudy->hifz_to_sura_id,
            hifz_to_ayah: $dailyStudy->hifz_to_ayah,
            hifz_pages: $dailyStudy->hifz_pages,
            murajaah_from_sura_id: $dailyStudy->murajaah_from_sura_id,
            murajaah_from_ayah: $dailyStudy->murajaah_from_ayah,
            murajaah_to_sura_id: $dailyStudy->murajaah_to_sura_id,
            murajaah_to_ayah: $dailyStudy->murajaah_to_ayah,
            murajaah_pages: $dailyStudy->murajaah_pages,
            points: $dailyStudy->points,
            attendance_status: $dailyStudy->attendance_status,
            notes: $dailyStudy->notes,
            is_active: $dailyStudy->is_active,
            created_at: optional($dailyStudy->created_at)->toDateTimeString(),
            updated_at: optional($dailyStudy->updated_at)->toDateTimeString(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'session_id' => $this->session_id,
            'student_id' => $this->student_id,
            'student_name' => $this->student_name,
            'hifz_from_sura_id' => $this->hifz_from_sura_id,
            'hifz_from_ayah' => $this->hifz_from_ayah,
            'hifz_to_sura_id' => $this->hifz_to_sura_id,
            'hifz_to_ayah' => $this->hifz_to_ayah,
            'hifz_pages' => $this->hifz_pages,
            'murajaah_from_sura_id' => $this->murajaah_from_sura_id,
            'murajaah_from_ayah' => $this->murajaah_from_ayah,
            'murajaah_to_sura_id' => $this->murajaah_to_sura_id,
            'murajaah_to_ayah' => $this->murajaah_to_ayah,
            'murajaah_pages' => $this->murajaah_pages,
            'points' => $this->points,
            'attendance_status' => $this->attendance_status,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'student_name' => $this->student_name,
            'attendance_status' => $this->attendance_status,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
        ];
    }
}
