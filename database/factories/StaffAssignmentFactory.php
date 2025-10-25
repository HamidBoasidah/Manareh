<?php

namespace Database\Factories;

use App\Models\StaffAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffAssignmentFactory extends Factory
{
    protected $model = StaffAssignment::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'role_in_circle' => $this->faker->randomElement(['teacher','supervisor_edu','supervisor_tarbawi']),
            'start_at' => $this->faker->date(),
            'end_at' => null,
            'notes' => $ar->sentence(),
        ];
    }
}
