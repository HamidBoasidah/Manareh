<?php

namespace Database\Factories;

use App\Models\Mosque;
use Illuminate\Database\Eloquent\Factories\Factory;

class MosqueFactory extends Factory
{
    protected $model = Mosque::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');

        return [
            'name' => $ar->company(),
            'city' => $ar->city(),
            'address' => $ar->address(),
            'phone' => $ar->phoneNumber(),
            'notes' => $ar->sentence(),
        ];
    }
}
