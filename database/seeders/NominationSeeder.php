<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nomination;
use App\Models\Circle;
use App\Models\Student;
use App\Models\Plan;
use App\Models\Term;
use App\Models\User;
use Illuminate\Support\Arr;


class NominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Prefer linking nominations to existing records created by earlier seeders.
        $circleIds = Circle::pluck('id')->toArray();
        $studentIds = Student::pluck('id')->toArray();
    $academicYearIds = \App\Models\AcademicYear::pluck('id')->toArray();
        $termIds = Term::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // If required related data is missing, skip seeding nominations to avoid creating
        // related models with incomplete factories (which can trigger DB constraint errors).
        if (empty($circleIds) || empty($studentIds) || empty($academicYearIds) || empty($termIds) || empty($userIds)) {
            // Nothing to do — dependent seeders should run before this seeder.
            return;
        }

        $faker = \Faker\Factory::create('ar_SA');
        $types = ['supervisor_nomination','ideal_student','reader_of_month'];

        for ($i = 0; $i < 50; $i++) {
            // Build attributes using existing IDs so factory won't create related models.
            $attributes = [
                'circle_id' => Arr::random($circleIds),
                'student_id' => Arr::random($studentIds),
                'nomination_type' => Arr::random($types),
                'academic_year_id' => Arr::random($academicYearIds),
                'term_id' => Arr::random($termIds),
                'nominated_by' => Arr::random($userIds),
                'notes' => $faker->sentence(),
            ];

            // If this nomination is supervisor type, create a linked Exam and set exam_id.
            if ($attributes['nomination_type'] === 'supervisor_nomination') {
                $examType = $faker->randomElement(['stage', 'juzz']);
                $examAttributes = [
                    'circle_id' => $attributes['circle_id'],
                    'student_id' => $attributes['student_id'],
                    'exam_type' => $examType,
                    'exam_date_g' => now()->toDateString(),
                ];

                if ($examType === 'stage') {
                    $examAttributes['stage'] = $faker->numberBetween(1, 10);
                } else {
                    $examAttributes['juzz'] = $faker->numberBetween(1, 30);
                }

                $exam = \App\Models\Exam::factory()->create($examAttributes);
                // create default exam items (q1..q6, t1, t2) with max_points = 10 for seeded exams
                try {
                    $keys = array_merge(array_map(fn($i) => 'q'.$i, range(1,6)), ['t1', 't2']);
                    $now = now();
                    $insert = [];
                    foreach ($keys as $k) {
                        $insert[] = [
                            'exam_id' => $exam->id,
                            'item_key' => $k,
                            'max_points' => 10,
                            'score_points' => 0,
                            'is_active' => true,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                    \App\Models\ExamItem::insert($insert);
                } catch (\Throwable $e) {
                    // ignore seeder-level failures for items so seeding can continue
                }
                // we'll link the exam to the nomination after the nomination is created
            }

            // Use the factory to make a model (so default attributes like timestamps etc. are applied),
            // but pass concrete foreign keys to avoid creating related models that might be incomplete.
            $nom = Nomination::factory()->make($attributes);
            $nom->save();

            // If we created an exam above for this nomination, link it via exams.nomination_id
            if (isset($exam) && $exam instanceof \App\Models\Exam) {
                $exam->nomination_id = $nom->id;
                $exam->save();
            }
        }
    }
}
