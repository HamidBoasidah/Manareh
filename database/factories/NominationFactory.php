<?php

namespace Database\Factories;

use App\Models\Nomination;
use App\Models\Circle;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NominationFactory extends Factory
{
    protected $model = Nomination::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');

        return [
            'circle_id' => Circle::factory(),
            'student_id' => Student::factory(),
            'nomination_type' => $this->faker->randomElement(['ideal_student','reader_of_month','best_behavior']),
            'month_ref' => $this->faker->monthName(),
            'term_id' => Term::factory(),
            'nominated_by' => User::factory(),
            'status' => $this->faker->randomElement(['pending','approved','rejected']),
            'approved_by' => null,
            'approved_at' => null,
            'notes' => $ar->sentence(),
        ];
    }
}
