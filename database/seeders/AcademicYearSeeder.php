<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        Mosque::all()->each(function ($mosque) {
            AcademicYear::factory()->for($mosque)->create();
        });
    }
}
