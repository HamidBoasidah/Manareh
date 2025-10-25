<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesPermissionsSeeder::class,
            UserSeeder::class,
            GovernorateSeeder::class,
            DistrictSeeder::class,
            AreaSeeder::class,
            MosqueSeeder::class,
            CircleClassificationSeeder::class,
            CircleSeeder::class,
            ProgramSeeder::class,
            PlanSeeder::class,
            AcademicYearSeeder::class,
            TermSeeder::class,
            GuardianSeeder::class,
            StudentSeeder::class,
            StaffAssignmentSeeder::class,
            EnrollmentSeeder::class,
            ExamTypeSeeder::class,
            ActivitySeeder::class,
            MessageTemplateSeeder::class,
            CertificateTemplateSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
