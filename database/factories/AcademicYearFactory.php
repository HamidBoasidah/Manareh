<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicYearFactory extends Factory
{
    protected $model = AcademicYear::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        $start = $this->faker->date();
        $end = $this->faker->date();

        return [
            'name' => $ar->year(),
            'start_date_g' => $start,
            'end_date_g' => $end,
            'start_date_h' => null,
            'end_date_h' => null,
        ];
    }
}
