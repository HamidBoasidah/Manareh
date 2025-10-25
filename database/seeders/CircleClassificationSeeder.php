<?php

namespace Database\Seeders;

use App\Models\CircleClassification;
use Illuminate\Database\Seeder;

class CircleClassificationSeeder extends Seeder
{
    public function run(): void
    {
        CircleClassification::factory()->count(4)->create();
    }
}
