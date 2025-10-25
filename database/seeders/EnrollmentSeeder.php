<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Circle;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $circles = Circle::all();
        if ($students->isEmpty() || $circles->isEmpty()) {
            return;
        }

        foreach ($students as $student) {
            $circle = $circles->random();
            Enrollment::factory()->for($circle)->create([ 'student_id' => $student->id ]);
        }
    }
}
