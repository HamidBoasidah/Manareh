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
            'address' => $ar->address(),
            'phone_number' => $ar->phoneNumber(),
            'whatsapp_number' => $ar->phoneNumber(),
            'nationality' => $ar->country(),
            'notes' => $ar->sentence(),
        ];
    }
}
