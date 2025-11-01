<?php

namespace Database\Factories;

use App\Models\ExamType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamTypeFactory extends Factory
{
    protected $model = ExamType::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'name' => $ar->word(),
            'is_active' => true,
        ];
    }
}
