<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition()
    {
        return [
            'exam_date_g' => $this->faker->date(),
            'exam_date_h' => null,
            'juzz' => null,
            'total_points' => $this->faker->numberBetween(0,100),
            'total_grade' => null,
            'remarks' => null,
        ];
    }
}
