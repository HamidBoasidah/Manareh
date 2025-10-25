<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'title' => $ar->sentence(3),
            'description' => $ar->paragraph(),
            'activity_date_g' => $this->faker->date(),
            'activity_date_h' => null,
            'place' => $ar->city(),
            'created_by' => null,
        ];
    }
}
