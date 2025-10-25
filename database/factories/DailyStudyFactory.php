<?php

namespace Database\Factories;

use App\Models\DailyStudy;
use App\Models\DailyStudySession;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyStudyFactory extends Factory
{
    protected $model = DailyStudy::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');

        return [
            'session_id' => DailyStudySession::factory(),
            'student_id' => Student::factory(),
            'hifz_from_sura_id' => $this->faker->numberBetween(1,114),
            'hifz_from_ayah' => $this->faker->numberBetween(1,7),
            'hifz_to_sura_id' => $this->faker->numberBetween(1,114),
            'hifz_to_ayah' => $this->faker->numberBetween(1,7),
            'hifz_pages' => $this->faker->numberBetween(0,10),
            'murajaah_from_sura_id' => $this->faker->numberBetween(1,114),
            'murajaah_from_ayah' => $this->faker->numberBetween(1,7),
            'murajaah_to_sura_id' => $this->faker->numberBetween(1,114),
            'murajaah_to_ayah' => $this->faker->numberBetween(1,7),
            'murajaah_pages' => $this->faker->numberBetween(0,10),
            'points' => $this->faker->numberBetween(0,3),
            'attendance_status' => $this->faker->randomElement(['present','absent','excused','late_in','early_out']),
            'notes' => $ar->sentence(),
        ];
    }
}
