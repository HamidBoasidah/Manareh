<?php

namespace Database\Factories;

use App\Models\CircleClassification;
use Illuminate\Database\Eloquent\Factories\Factory;

class CircleClassificationFactory extends Factory
{
    protected $model = CircleClassification::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'name' => $ar->word(),
        ];
    }
}
