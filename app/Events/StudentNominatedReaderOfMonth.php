<?php

namespace App\Events;

use App\Models\Circle;
use App\Models\Student;
use App\Models\User;

class StudentNominatedReaderOfMonth extends AbstractNotificationEvent
{
    public function __construct(Student $student, Circle $circle, User $supervisor, ?string $note = null)
    {
        $student->loadMissing('user:id,name');
        $circle->loadMissing('mosque:id,name');

        parent::__construct(
            userId: $student->user_id,
            templateCode: 'STUDENT_NOMINATED_READER_OF_MONTH',
            variables: [
                'student_name' => $student->user?->name ?? '-',
                'circle_name' => $circle->name,
                'supervisor_name' => $supervisor->name,
            ],
            payload: [
                'student_id' => $student->id,
                'circle_id' => $circle->id,
                'supervisor_id' => $supervisor->id,
                'note' => $note,
            ],
            mosqueId: $circle->mosque_id,
        );
    }
}
