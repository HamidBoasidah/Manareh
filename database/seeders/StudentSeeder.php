<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Guardian;
use App\Models\Role;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // ensure the 'student' role exists
        $studentRole = Role::firstOrCreate(
            ['name' => 'student'],
            ['display_name' => ['en' => 'Student', 'ar' => 'طالب'], 'guard_name' => config('acl.guard', 'web')]
        );

        $users = User::factory()->count(20)->create();
        $guardians = Guardian::all();
        if ($guardians->isEmpty()) {
            $guardians = Guardian::factory()->count(5)->create();
        }

        foreach ($users as $user) {
            // ensure this user has the 'student' role
            if (! $user->hasRole($studentRole->name)) {
                $user->assignRole($studentRole->name);
            }

            $guardian = $guardians->random();
            Student::factory()->for($guardian)->create([ 'user_id' => $user->id ]);
        }
    }
}
