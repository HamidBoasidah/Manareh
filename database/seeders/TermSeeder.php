<?php

namespace Database\Seeders;

use App\Models\Term;
use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    public function run(): void
    {
        AcademicYear::all()->each(function ($year) {
            Term::factory()->count(2)->for($year)->create();
        });
    }
}
