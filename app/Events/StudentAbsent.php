<?php

namespace App\Events;

use App\Models\Circle;
use App\Models\Student;
use App\Models\User;

class StudentAbsent extends AbstractNotificationEvent
{
    public function __construct(Student $student, Circle $circle, string $dateG, ?User $teacher = null)
    {
        $student->loadMissing('user:id,name');
        $circle->loadMissing('mosque:id,name');

        parent::__construct(
            userId: $student->user_id,
            templateCode: 'STUDENT_ABSENT_TODAY',
            variables: [
                'student_name' => $student->user?->name ?? '-',
                'circle_name' => $circle->name,
                'date_g' => $dateG,
                'teacher_name' => $teacher?->name ?? '-',
            ],
            payload: [
                'student_id' => $student->id,
                'circle_id' => $circle->id,
                'attendance_date' => $dateG,
                'teacher_id' => $teacher?->id,
            ],
            mosqueId: $circle->mosque_id,
        );
    }
}
