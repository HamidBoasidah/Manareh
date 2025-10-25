<?php

namespace Database\Factories;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['active','on_hold','graduated','withdrawn']),
            'joined_at' => $this->faker->date(),
            'left_at' => null,
        ];
    }
}
