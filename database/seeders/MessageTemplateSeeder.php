<?php

namespace Database\Seeders;

use App\Models\MessageTemplate;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        Mosque::all()->each(function ($mosque) {
            MessageTemplate::factory()->count(2)->for($mosque)->create();
        });
    }
}
