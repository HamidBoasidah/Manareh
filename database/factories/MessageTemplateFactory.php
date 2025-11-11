<?php

namespace Database\Factories;

use App\Models\MessageTemplate;
use App\Models\Mosque;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageTemplateFactory extends Factory
{
    protected $model = MessageTemplate::class;

    public function definition(): array
    {
        return [
            // لمّا تستعمل factory مباشرة، إن ما حددت mosque_id
            // يقدر Laravel ينشئ Mosque تلقائياً لو عندك MosqueFactory
            'mosque_id'   => Mosque::query()->inRandomOrder()->value('id') ?? null,

            // كود تجريبي واضح أنه للاختبار فقط
            'code'        => 'TEST_' . strtoupper($this->faker->unique()->lexify('TEMPLATE_????')),

            'channel'     => 'inbox',
            'locale'      => 'ar',

            'subject'     => $this->faker->sentence(4),
            'body'        => "هذه رسالة تجريبية: {student_name} في حلقة {circle_name}.\n" .
                             $this->faker->sentence(8),

            'description' => 'قالب تجريبي تم إنشاؤه بواسطة factory للاختبارات.',
            'is_active'   => true,
        ];
    }

    /**
     * حالة: قالب غير مفعّل
     */
    public function inactive(): self
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    /**
     * حالة: قالب عام (بدون مسجد محدد)
     */
    public function global(): self
    {
        return $this->state(fn () => [
            'mosque_id' => null,
        ]);
    }
}
