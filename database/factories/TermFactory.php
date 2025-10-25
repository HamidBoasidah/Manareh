<?php

namespace Database\Factories;

use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

class TermFactory extends Factory
{
    protected $model = Term::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'name' => $this->faker->randomElement(['T1','T2']),
            'start_date_g' => $this->faker->date(),
            'end_date_g' => $this->faker->date(),
            'start_date_h' => null,
            'end_date_h' => null,
        ];
    }
}
