<?php

namespace App\Events;

use App\Models\Circle;
use App\Models\Student;
use App\Models\User;

class StudentAddedToCircle extends AbstractNotificationEvent
{
    public function __construct(Student $student, Circle $circle, ?User $teacher = null)
    {
        $student->loadMissing('user:id,name');
        $circle->loadMissing('mosque:id,name');

        $studentName = $student->user?->name ?? '-';
        $teacherName = $teacher?->name ?? '-';

        parent::__construct(
            userId: $student->user_id,
            templateCode: 'STUDENT_ADDED_TO_CIRCLE',
            variables: [
                'student_name' => $studentName,
                'circle_name' => $circle->name,
                'teacher_name' => $teacherName,
            ],
            payload: [
                'student_id' => $student->id,
                'circle_id' => $circle->id,
                'teacher_id' => $teacher?->id,
            ],
            mosqueId: $circle->mosque_id,
        );
    }
}
