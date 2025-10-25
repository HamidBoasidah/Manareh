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

        foreach ($circles as $circle) {
            $teacher = $users->random();
            StaffAssignment::factory()->for($circle)->create([ 'user_id' => $teacher->id ]);
        }
    }
}
