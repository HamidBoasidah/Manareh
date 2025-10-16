<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkingPeriod;

class WorkingPeriodSeeder extends Seeder
{
    public function run(): void
    {
        WorkingPeriod::factory(30)->create();
    }
}
