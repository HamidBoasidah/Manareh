<?php

namespace Database\Seeders;

use App\Models\Mosque;
use Illuminate\Database\Seeder;

class MosqueSeeder extends Seeder
{
    public function run(): void
    {
        // create 3 mosques
        Mosque::factory()->count(3)->create();
    }
}
