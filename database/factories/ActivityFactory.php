<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        // Prefer an existing user as the creator; if none exists, create one.
        $creator = User::inRandomOrder()->first();
        if (! $creator) {
            $creator = User::factory()->create();
        }

        return [
            'title' => $ar->sentence(3),
            'description' => $ar->paragraph(),
            'activity_date_g' => $this->faker->date(),
            'activity_date_h' => null,
            'place' => $ar->city(),
            'created_by' => $creator->id,
        ];
    }
}
