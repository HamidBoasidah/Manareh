<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'name' => $ar->word(),
            'type' => $ar->word(),
            'description' => $ar->sentence(),
        ];
    }
}
