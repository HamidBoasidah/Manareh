<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * قائمة الأحداث والمستمعين المسجّلين في النظام.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // 🟢 عندما يُضاف طالب إلى حلقة
        \App\Events\StudentAddedToCircle::class => [
            \App\Listeners\SendNotificationListener::class,
        ],

        // 🟢 عند غياب الطالب
        \App\Events\StudentAbsent::class => [
            \App\Listeners\SendNotificationListener::class,
        ],

        // 🟢 عند ترشيحه قارئ الشهر
        \App\Events\StudentNominatedReaderOfMonth::class => [
            \App\Listeners\SendNotificationListener::class,
        ],

        // 🟢 عند صدور نتيجة الاختبار
        \App\Events\StudentExamResultReleased::class => [
            \App\Listeners\SendNotificationListener::class,
        ],
    ];

    /**
     * تسجيل أي أحداث إضافية.
     */
    public function boot(): void
    {
        //
    }

    /**
     * لتفعيل الاكتشاف التلقائي للأحداث (اختياري).
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
