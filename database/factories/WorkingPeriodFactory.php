<?php
namespace Database\Factories;

use App\Models\WorkingPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkingPeriodFactory extends Factory
{
    protected $model = WorkingPeriod::class;

    public function definition()
    {
        return [
            'day' => $this->faker->randomElement(['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday']),
            'from_time' => $this->faker->time('H:i'),
            'to_time' => $this->faker->time('H:i'),
            'is_active' => true,
            'medical_facility_id' => \App\Models\MedicalFacility::inRandomOrder()->first()?->id,
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id,
            'updated_by' => \App\Models\User::inRandomOrder()->first()?->id,
        ];
    }
}
