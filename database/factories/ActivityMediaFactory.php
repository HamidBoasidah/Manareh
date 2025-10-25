<?php

namespace Database\Factories;

use App\Models\ActivityMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityMediaFactory extends Factory
{
    protected $model = ActivityMedia::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'type' => $this->faker->randomElement(['image','video','file']),
            'path' => 'media/' . $this->faker->uuid() . '.jpg',
            'caption' => $ar->sentence(),
        ];
    }
}
