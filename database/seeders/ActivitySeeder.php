<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Mosque::all()->each(function ($mosque) {
            Activity::factory()->count(2)->for($mosque)->create();
        });
    }
}
