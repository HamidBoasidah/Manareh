<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        Mosque::all()->each(function ($mosque) {
            Program::factory()->count(2)->for($mosque)->create();
        });
    }
}
