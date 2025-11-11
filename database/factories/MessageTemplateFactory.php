<?php

namespace Database\Factories;

use App\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MessageTemplateFactory extends Factory
{
    protected $model = MessageTemplate::class;

    public function definition()
    {
        $name = Str::headline($this->faker->unique()->words(3, true));
        $code = strtoupper(Str::snake($name));
        $channel = $this->faker->randomElement(MessageTemplate::CHANNELS);
        $locale = $this->faker->randomElement(MessageTemplate::availableLocales());

        $body = 'مرحبا {{guardian_name}}، الطالب {{student_name}} لديه تحديث بتاريخ {{date}}.';
        if ($locale === 'en') {
            $body = 'Hello {{guardian_name}}, student {{student_name}} has an update on {{date}}.';
        }

        return [
            'code' => $code,
            'name' => $name,
            'channel' => $channel,
            'locale' => $locale,
            'subject' => $channel === MessageTemplate::CHANNEL_EMAIL ? $this->faker->sentence(6) : null,
            'description' => $this->faker->sentence(),
            'body' => $body,
            'variables' => [
                [
                    'key' => 'guardian_name',
                    'label' => 'Guardian Name',
                    'type' => 'string',
                    'required' => true,
                ],
                [
                    'key' => 'student_name',
                    'label' => 'Student Name',
                    'type' => 'string',
                    'required' => true,
                ],
                [
                    'key' => 'date',
                    'label' => 'Date',
                    'type' => 'date',
                    'required' => true,
                ],
            ],
            'sample_payload' => [
                'guardian_name' => $locale === 'en' ? 'Ahmed' : 'أحمد',
                'student_name' => $locale === 'en' ? 'Mohammed' : 'محمد',
                'date' => now()->format('Y-m-d'),
            ],
            'extras' => [
                'cta' => [
                    'label' => $locale === 'en' ? 'Open Portal' : 'فتح البوابة',
                    'url' => 'https://example.com',
                ],
            ],
            'is_active' => true,
        ];
    }
}
