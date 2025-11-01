<?php

namespace Database\Factories;

use App\Models\DailyStudySession;
use App\Models\Circle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyStudySessionFactory extends Factory
{
    protected $model = DailyStudySession::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');

        return [
            'circle_id' => Circle::factory(),
            'session_date_g' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'session_date_h' => $ar->date('Y-m-d'),
            'created_by' => User::factory(),
            'is_active' => $this->faker->boolean(85),
        ];
    }
}
