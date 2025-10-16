<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalFacilityCategory;

class MedicalFacilityCategorySeeder extends Seeder
{
    public function run(): void
    {
        MedicalFacilityCategory::factory(8)->create();
    }
}
