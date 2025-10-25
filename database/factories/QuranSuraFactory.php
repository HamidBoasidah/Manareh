<?php

namespace Database\Factories;

use App\Models\QuranSura;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuranSuraFactory extends Factory
{
    protected $model = QuranSura::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');

        return [
            'name_ar' => $ar->word() . ' ' . $ar->word(),
            'name_en' => $ar->word(),
            'ayah_count' => $this->faker->numberBetween(1, 286),
        ];
    }
}
