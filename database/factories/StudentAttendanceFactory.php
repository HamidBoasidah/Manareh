<?php

namespace Database\Factories;

use App\Models\StudentAttendance;
use App\Models\Circle;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentAttendanceFactory extends Factory
{
    protected $model = StudentAttendance::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');

        return [
            'circle_id' => Circle::factory(),
            'student_id' => Student::factory(),
            'date_g' => $this->faker->date(),
            'date_h' => $ar->date(),
            'status' => $this->faker->randomElement(['present','absent','excused','late_in','early_out']),
            'reason' => $ar->sentence(),
            'recorded_by' => User::factory(),
        ];
    }
}
