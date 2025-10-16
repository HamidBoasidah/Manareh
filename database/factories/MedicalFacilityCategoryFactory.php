<?php
namespace Database\Factories;

use App\Models\MedicalFacilityCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalFacilityCategoryFactory extends Factory
{
    protected $model = MedicalFacilityCategory::class;

    public function definition()
    {
        return [
            'name_ar' => $this->faker->word . ' عربي',
            'name_en' => $this->faker->word,
            'is_active' => true,
            'is_parentable' => false,
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id,
            'updated_by' => \App\Models\User::inRandomOrder()->first()?->id,
        ];
    }
}
