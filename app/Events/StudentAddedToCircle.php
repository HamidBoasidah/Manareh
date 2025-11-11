<?php

namespace App\Events;

use App\Models\Student;
use App\Models\Circle;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentAddedToCircle
{
    use Dispatchable, SerializesModels;

    public Student $student;
    public Circle $circle;
    public User $teacher;

    public function __construct(Student $student, Circle $circle, User $teacher)
    {
        $this->student = $student;
        $this->circle  = $circle;
        $this->teacher = $teacher;
    }
}
