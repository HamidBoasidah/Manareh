<?php
namespace Database\Factories;

use App\Models\MedicalFacility;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalFacilityFactory extends Factory
{
    protected $model = MedicalFacility::class;

    public function definition()
    {
        return [
            'name_ar' => $this->faker->company . ' عربي',
            'name_en' => $this->faker->company,
            'attachment' => null,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'landline_number' => $this->faker->phoneNumber,
            'whatsapp_number' => $this->faker->phoneNumber,
            'facility_ownership_id' => \App\Models\FacilityOwnership::inRandomOrder()->first()?->id,
            'governorate_id' => \App\Models\Governorate::inRandomOrder()->first()?->id,
            'district_id' => \App\Models\District::inRandomOrder()->first()?->id,
            'area_id' => \App\Models\Area::inRandomOrder()->first()?->id,
            'medical_facility_category_id' => \App\Models\MedicalFacilityCategory::inRandomOrder()->first()?->id,
            'parent_id' => null,
            'is_general' => false,
            'specialty_id' => \App\Models\Specialty::inRandomOrder()->first()?->id,
            'is_active' => true,
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id,
            'updated_by' => \App\Models\User::inRandomOrder()->first()?->id,
        ];
    }
}
