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
            QuranSuraSeeder::class,
            UserSeeder::class,
            GovernorateSeeder::class,
            DistrictSeeder::class,
            AreaSeeder::class,
            MosqueSeeder::class,
            CircleClassificationSeeder::class,
            CircleSeeder::class,
            StaffRolesSeeder::class,
            ProgramSeeder::class,
            PlanSeeder::class,
            AcademicYearSeeder::class,
            TermSeeder::class,
            GuardianSeeder::class,
            StudentSeeder::class,
            StaffAssignmentSeeder::class,
            EnrollmentSeeder::class,
            DailyStudySessionSeeder::class,
            NominationSeeder::class,
            // Exam types are now represented as an enum on the `exams` table
            // and we no longer maintain a separate `exam_types` table.
            // Disable the old seeder to avoid creating unused records.
            // ExamTypeSeeder::class,
            ActivitySeeder::class,
            MessageTemplateSeeder::class,
            CertificateTemplateSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
