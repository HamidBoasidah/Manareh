<?php

namespace Database\Factories;

use App\Models\Guardian;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuardianFactory extends Factory
{
    protected $model = Guardian::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'name' => $ar->name(),
            'phone_number' => $ar->phoneNumber(),
            'whatsapp_number' => $ar->phoneNumber(),
            'relation' => $ar->word(),
        ];
    }
}
