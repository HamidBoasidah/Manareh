<?php

namespace Database\Seeders;

use App\Models\CertificateTemplate;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class CertificateTemplateSeeder extends Seeder
{
    public function run(): void
    {
        Mosque::all()->each(function ($mosque) {
            CertificateTemplate::factory()->count(1)->for($mosque)->create();
        });
    }
}
