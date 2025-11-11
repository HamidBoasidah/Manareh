<?php

namespace App\Events;

use App\Models\Exam;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentExamResultReleased
{
    use Dispatchable, SerializesModels;

    public Exam $exam;

    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }
}
