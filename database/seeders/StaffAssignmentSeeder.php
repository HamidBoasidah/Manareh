<?php

namespace Database\Seeders;

use App\Models\StaffAssignment;
use App\Models\User;
use App\Models\Circle;
use Illuminate\Database\Seeder;

class StaffAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $circles = Circle::all();
        if ($users->isEmpty() || $circles->isEmpty()) {
            return;
        }

        // Determine users that already have an open 'teacher' assignment to avoid unique index violations
        $usedTeacherIds = StaffAssignment::where('role_in_circle', 'teacher')
            ->where('is_active', 1)
            ->whereNull('end_at')
            ->whereNull('deleted_at')
            ->pluck('user_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        $available = $users->whereNotIn('id', $usedTeacherIds)->values();

        foreach ($circles as $circle) {
            // pick a user who doesn't already have an open teacher assignment
            $teacher = $available->pop() ?? null;

            if ($teacher) {
                StaffAssignment::factory()->for($circle)->create([ 'user_id' => $teacher->id ]);
            } else {
                // No available fresh teacher users: create a non-open assignment to avoid uniqueness conflict
                $fallback = $users->random();
                StaffAssignment::factory()->for($circle)->create([
                    'user_id' => $fallback->id,
                    // mark as ended so it doesn't violate the unique "one open teacher" index
                    'end_at' => now()->subDays(rand(1, 365)),
                    'is_active' => 0,
                ]);
            }
        }
    }
}
