<?php

namespace Database\Factories;

use App\Models\Nomination;
use App\Models\Circle;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Exam;
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
            'nomination_type' => $this->faker->randomElement(['supervisor_nomination','ideal_student','reader_of_month']),
            'academic_year_id' => AcademicYear::factory(),
            'term_id' => Term::factory(),
            'nominated_by' => User::factory(),
            'status' => Nomination::STATUS_SUBMITTED,
            'notes' => $ar->sentence(),
        ];
    }
}
