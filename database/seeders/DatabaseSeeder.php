<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesPermissionsSeeder::class,
            UserSeeder::class,
            GovernorateSeeder::class,
            DistrictSeeder::class,
            AreaSeeder::class,
            FacilityOwnershipSeeder::class,
            MedicalFacilityCategorySeeder::class,
            SpecialtySeeder::class,
            MedicalFacilitySeeder::class,
            MedicalServiceSeeder::class,
            WorkingPeriodSeeder::class,
            ContentBlockSeeder::class,
            AdvertisementSeeder::class,
            ConversationSeeder::class,
        ]);
    }
}
