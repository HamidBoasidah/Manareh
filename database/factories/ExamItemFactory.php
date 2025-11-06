<?php

namespace Database\Factories;

use App\Models\ExamItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamItemFactory extends Factory
{
    protected $model = ExamItem::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'item_key' => 'item_' . $this->faker->randomNumber(2),
            'max_points' => $this->faker->numberBetween(1,20),
            'score_points' => 0,
            'is_active' => true,
        ];
    }
}
