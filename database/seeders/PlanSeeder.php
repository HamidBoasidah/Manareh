<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        // plans have minimal columns for now
        Plan::factory()->count(2)->create();
    }
}
