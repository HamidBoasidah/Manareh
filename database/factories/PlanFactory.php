<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            // currently plans table has no fields besides timestamps and is_active
        ];
    }
}
