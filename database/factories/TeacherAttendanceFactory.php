<?php

namespace Database\Factories;

use App\Models\TeacherAttendance;
use App\Models\Circle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherAttendanceFactory extends Factory
{
    protected $model = TeacherAttendance::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');

        return [
            'circle_id' => Circle::factory(),
            'user_id' => User::factory(),
            'date_g' => $this->faker->date(),
            'date_h' => $ar->date(),
            'status' => $this->faker->randomElement(['present','absent','excused','late_in','early_out']),
            'notes' => $ar->sentence(),
        ];
    }
}
