<?php

namespace App\Events;

use App\Models\Circle;
use App\Models\Student;

class StudentExamResultReleased extends AbstractNotificationEvent
{
    public function __construct(
        Student $student,
        ?Circle $circle,
        string $examType,
        float|int $totalPoints,
        string $totalGrade,
        ?string $examDateG = null,
        array $extraPayload = []
    ) {
        $student->loadMissing('user:id,name');
        $circle?->loadMissing('mosque:id,name');

        $payload = array_merge([
            'student_id' => $student->id,
            'circle_id' => $circle?->id,
            'exam_type' => $examType,
            'total_points' => $totalPoints,
            'total_grade' => $totalGrade,
            'exam_date_g' => $examDateG,
        ], $extraPayload);

        parent::__construct(
            userId: $student->user_id,
            templateCode: 'STUDENT_EXAM_RESULT',
            variables: [
                'student_name' => $student->user?->name ?? '-',
                'exam_type' => $examType,
                'total_points' => $totalPoints,
                'total_grade' => $totalGrade,
                'exam_date_g' => $examDateG ?? '-',
            ],
            payload: $payload,
            mosqueId: $circle?->mosque_id,
        );
    }
}
