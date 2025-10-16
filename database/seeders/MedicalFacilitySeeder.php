<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalFacility;

class MedicalFacilitySeeder extends Seeder
{
    public function run(): void
    {
        MedicalFacility::factory(20)->create();
    }
}
