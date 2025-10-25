<?php

namespace Database\Seeders;

use App\Models\ExamType;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class ExamTypeSeeder extends Seeder
{
    public function run(): void
    {
        Mosque::all()->each(function ($mosque) {
            ExamType::factory()->count(2)->for($mosque)->create();
        });
    }
}
