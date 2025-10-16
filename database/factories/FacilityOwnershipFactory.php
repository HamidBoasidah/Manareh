<?php
namespace Database\Factories;

use App\Models\FacilityOwnership;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacilityOwnershipFactory extends Factory
{
    protected $model = FacilityOwnership::class;

    public function definition()
    {
        return [
            'name_ar' => $this->faker->word . ' عربي',
            'name_en' => $this->faker->word,
            'is_active' => true,
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id,
            'updated_by' => \App\Models\User::inRandomOrder()->first()?->id,
        ];
    }
}
