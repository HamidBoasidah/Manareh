<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'birth_date' => $this->faker->date(),
            'nationality' => $ar->country(),
            'notes' => $ar->sentence(),
        ];
    }
}
