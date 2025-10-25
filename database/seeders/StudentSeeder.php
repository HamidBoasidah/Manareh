<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Guardian;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()->count(10)->create();
        $guardians = Guardian::all();
        if ($guardians->isEmpty()) {
            $guardians = Guardian::factory()->count(5)->create();
        }

        foreach ($users as $user) {
            $guardian = $guardians->random();
            Student::factory()->for($guardian)->create([ 'user_id' => $user->id ]);
        }
    }
}
