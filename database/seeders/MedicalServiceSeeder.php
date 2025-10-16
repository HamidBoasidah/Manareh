<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalService;

class MedicalServiceSeeder extends Seeder
{
    public function run(): void
    {
        MedicalService::factory(15)->create();
    }
}
