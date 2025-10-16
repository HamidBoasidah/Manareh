<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FacilityOwnership;

class FacilityOwnershipSeeder extends Seeder
{
    public function run(): void
    {
        FacilityOwnership::factory(5)->create();
    }
}
