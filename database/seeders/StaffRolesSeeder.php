<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class StaffRolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'teacher' => ['en' => 'Teacher', 'ar' => 'معلم'],
            'supervisor_edu' => ['en' => 'Educational Supervisor', 'ar' => 'مشرف (تعليمي)'],
            'supervisor_tarbawi' => ['en' => 'Tarbawi Supervisor', 'ar' => 'مشرف (تربوي)'],
        ];

        foreach ($roles as $name => $display) {
            Role::updateOrCreate(
                ['name' => $name, 'guard_name' => config('acl.guard', 'web')],
                ['display_name' => $display]
            );
        }
    }
}
