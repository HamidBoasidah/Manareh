<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'recipient_type' => 'user',
            'recipient_id' => 1,
            'channel' => $this->faker->randomElement(['inbox','sms','whatsapp','email']),
            'payload' => json_encode(['text' => $ar->sentence()]),
            'status' => 'queued',
            'sent_at' => null,
            'error' => null,
        ];
    }
}
