<?php

namespace Database\Factories;

use App\Models\Circle;
use Illuminate\Database\Eloquent\Factories\Factory;

class CircleFactory extends Factory
{
    protected $model = Circle::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'name' => $ar->word() . ' ' . $ar->randomDigitNotNull(),
            'capacity' => $this->faker->numberBetween(10, 50),
            'notes' => $ar->sentence(),
        ];
    }
}
