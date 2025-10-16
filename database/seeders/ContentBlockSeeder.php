<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentBlock;

class ContentBlockSeeder extends Seeder
{
    public function run(): void
    {
        ContentBlock::factory(10)->create();
    }
}
