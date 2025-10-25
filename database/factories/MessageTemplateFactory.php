<?php

namespace Database\Factories;

use App\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageTemplateFactory extends Factory
{
    protected $model = MessageTemplate::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'code' => strtoupper($this->faker->lexify('???')),
            'channel' => $this->faker->randomElement(['inbox','sms','whatsapp','email']),
            'subject' => $ar->sentence(),
            'body' => $ar->paragraph(),
        ];
    }
}
