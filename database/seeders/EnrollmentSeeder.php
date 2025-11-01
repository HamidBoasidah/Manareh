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
        Enrollment::query()->forceDelete();

        $students = Student::all();
        $circles = Circle::all();
        if ($students->isEmpty() || $circles->isEmpty()) {
            return;
        }

        $availableStudents = $students->shuffle();
        $faker = fake();

        foreach ($circles as $circle) {
            if ($availableStudents->isEmpty()) {
                break;
            }

            $studentsForCircle = $availableStudents->splice(0, 22);

            $studentsForCircle->each(function ($student) use ($circle, $faker) {
                $joinedAt = $faker->dateTimeBetween('-2 years', 'now');

                Enrollment::factory()
                    ->for($circle)
                    ->state([
                        'joined_at' => $joinedAt->format('Y-m-d'),
                        'left_at' => null,
                    ])
                    ->create([
                        'student_id' => $student->id,
                    ]);
            });
        }
    }
}
