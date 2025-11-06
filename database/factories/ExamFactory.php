<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition()
    {
        $examType = $this->faker->randomElement(['stage', 'juzz']);
        return [
            // exam_type is now an enum: 'stage' or 'juzz'
            'exam_type' => $examType,
            'exam_date_g' => $this->faker->date(),
            'exam_date_h' => null,
            // if exam_type is 'juzz' fill a random juzz 1..30, otherwise null
            'juzz' => $examType === 'juzz' ? $this->faker->numberBetween(1, 30) : null,
            // if exam_type is 'stage' fill a random stage 1..10, otherwise null
            'stage' => $examType === 'stage' ? $this->faker->numberBetween(1, 10) : null,
            'total_points' => $this->faker->numberBetween(0,100),
            'total_grade' => null,
            'remarks' => null,
        ];
    }
}
