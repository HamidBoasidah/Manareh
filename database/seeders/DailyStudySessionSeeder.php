<?php

namespace Database\Seeders;

use App\Models\Circle;
use App\Models\DailyStudySession;
use App\Models\User;
use Illuminate\Database\Seeder;

class DailyStudySessionSeeder extends Seeder
{
    public function run(): void
    {
        if (Circle::count() === 0) {
            Circle::factory()->count(5)->create();
        }

        if (User::count() === 0) {
            User::factory()->count(3)->create();
        }

        $userIds = User::pluck('id');

        Circle::all()->each(function (Circle $circle) use ($userIds) {
            $count = random_int(3, 6);
            $baseDate = now()->subDays(10);

            DailyStudySession::factory()
                ->count($count)
                ->sequence(fn ($sequence) => [
                    'circle_id' => $circle->id,
                    'created_by' => $userIds->random(),
                    'session_date_g' => $baseDate->copy()->addDays($sequence->index)->format('Y-m-d'),
                ])
                ->create();
        });
    }
}
