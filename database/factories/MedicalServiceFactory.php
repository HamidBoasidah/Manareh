<?php
namespace Database\Factories;

use App\Models\MedicalService;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalServiceFactory extends Factory
{
    protected $model = MedicalService::class;

    public function definition()
    {
        return [
            'name_ar' => $this->faker->word . ' عربي',
            'name_en' => $this->faker->word,
            'is_active' => true,
            'medical_facility_id' => \App\Models\MedicalFacility::inRandomOrder()->first()?->id,
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id,
            'updated_by' => \App\Models\User::inRandomOrder()->first()?->id,
        ];
    }
}
