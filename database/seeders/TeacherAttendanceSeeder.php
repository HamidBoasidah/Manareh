<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeacherAttendance;
use App\Models\User;
use App\Models\Circle;

class TeacherAttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $circles = Circle::all();
        if ($circles->isEmpty()) {
            $circles = Circle::factory()->count(3)->create();
        }

        // Prefer users that have the 'teacher' role or supervisor roles.
        // If roles package is not available or roles are missing, fallback to all users.
        try {
            $teachers = User::role(['teacher', 'supervisor_edu', 'supervisor_tarbawi'])->get();
        } catch (\Throwable $e) {
            $teachers = User::all();
        }

        if ($teachers->isEmpty()) {
            $teachers = User::factory()->count(5)->create();
            // attempt to assign 'teacher' role if possible
            foreach ($teachers as $u) {
                if (method_exists($u, 'assignRole')) {
                    try { $u->assignRole('teacher'); } catch (\Throwable $e) { /* ignore */ }
                }
            }
        }

        $recorders = User::all();
        if ($recorders->isEmpty()) {
            $recorders = User::factory()->count(3)->create();
        }

        $statusOptions = ['present','absent','excused','late_in','early_out','half_day','on_leave','sick'];
        $fakerAr = \Faker\Factory::create('ar_SA');

        // Create attendances specifically for the first 10 days of the current month.
        // For each day 1..10 create between 9 and 23 attendance records (random count).
        $startOfMonth = now()->startOfMonth();
        for ($day = 1; $day <= 10; $day++) {
            $entries = rand(9, 23);
            for ($j = 0; $j < $entries; $j++) {
                $teacher = $teachers->random();
                $circle = $circles->random();
                $recorder = $recorders->random();

                TeacherAttendance::factory()->create([
                    'user_id' => $teacher->id,
                    'circle_id' => $circle->id,
                    'recorded_by' => $recorder->id,
                    'status' => $statusOptions[array_rand($statusOptions)],
                    'date_g' => $startOfMonth->copy()->addDays($day - 1)->toDateString(),
                    'date_h' => $fakerAr->date(),
                ]);
            }
        }
    }
}
