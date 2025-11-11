protected $listen = [
    \App\Events\StudentAddedToCircle::class => [
        \App\Listeners\SendNotificationListener::class,
    ],
    \App\Events\StudentAbsent::class => [
        \App\Listeners\SendNotificationListener::class,
    ],
    \App\Events\StudentNominatedReaderOfMonth::class => [
        \App\Listeners\SendNotificationListener::class,
    ],
    \App\Events\StudentExamResultReleased::class => [
        \App\Listeners\SendNotificationListener::class,
    ],
];
