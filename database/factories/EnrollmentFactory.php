<?php

namespace Database\Factories;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition()
    {
        $joinedAt = $this->faker->dateTimeBetween('-2 years', 'now');
        $leftAt = $this->faker->boolean(30)
            ? $this->faker->dateTimeBetween($joinedAt, 'now')
            : null;

        return [
            'joined_at' => $joinedAt->format('Y-m-d'),
            'left_at' => $leftAt?->format('Y-m-d'),
        ];
    }
}
