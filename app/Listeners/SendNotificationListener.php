<?php

namespace App\Listeners;

use App\Events\StudentAddedToCircle;
use App\Events\StudentAbsent;
use App\Events\StudentNominatedReaderOfMonth;
use App\Events\StudentExamResultReleased;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationListener implements ShouldQueue
{
    protected NotificationService $notifications;

    public function __construct(NotificationService $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle($event): void
    {
        // 1) طالب أُضيف إلى حلقة
        if ($event instanceof StudentAddedToCircle) {
            $student = $event->student;
            $circle  = $event->circle;
            $teacher = $event->teacher;

            $this->notifications->sendUsingTemplate(
                'STUDENT_ADDED_TO_CIRCLE',
                $student->user_id,     // صاحب inbox
                'student',
                $student->id,
                $circle->mosque_id,
                [
                    'student_name' => $student->user->name,
                    'circle_name'  => $circle->name,
                    'teacher_name' => $teacher->name,
                ]
            );
        }

        // 2) غياب الطالب
        elseif ($event instanceof StudentAbsent) {
            $student = $event->student;
            $circle  = $event->circle;
            $teacher = $event->teacher;

            $this->notifications->sendUsingTemplate(
                'STUDENT_ABSENT_TODAY',
                $student->user_id,
                'student',
                $student->id,
                $circle->mosque_id,
                [
                    'student_name' => $student->user->name,
                    'circle_name'  => $circle->name,
                    'date_g'       => $event->date_g,
                    'teacher_name' => $teacher->name,
                ]
            );
        }

        // 3) ترشيح قارئ الشهر
        elseif ($event instanceof StudentNominatedReaderOfMonth) {
            $n = $event->nomination;
            $student = $n->student;
            $circle  = $n->circle;

            $this->notifications->sendUsingTemplate(
                'STUDENT_NOMINATED_READER_OF_MONTH',
                $student->user_id,
                'student',
                $student->id,
                $circle->mosque_id,
                [
                    'student_name'    => $student->user->name,
                    'circle_name'     => $circle->name,
                    'supervisor_name' => $n->nominatedBy->name ?? '',
                ]
            );
        }

        // 4) نتيجة الاختبار
        elseif ($event instanceof StudentExamResultReleased) {
            $exam    = $event->exam;
            $student = $exam->student;
            $circle  = $exam->circle;

            $this->notifications->sendUsingTemplate(
                'STUDENT_EXAM_RESULT',
                $student->user_id,
                'student',
                $student->id,
                $circle->mosque_id,
                [
                    'student_name' => $student->user->name,
                    'exam_type'    => $exam->exam_type,
                    'total_points' => $exam->total_points,
                    'total_grade'  => $exam->total_grade,
                ]
            );
        }
    }
}
