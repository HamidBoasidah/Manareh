<?php

namespace Database\Seeders;

use App\Models\Circle;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class CircleSeeder extends Seeder
{
    public function run(): void
    {
        Mosque::all()->each(function ($mosque) {
            Circle::factory()->count(3)->for($mosque)->create();
        });
    }
}
