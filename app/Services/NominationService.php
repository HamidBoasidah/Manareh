<?php

namespace App\Services;

use App\Repositories\NominationRepository;
use App\Models\Circle;
use App\Models\Student;
use App\Models\Plan;
use App\Models\Term;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamItem;
use Illuminate\Support\Facades\DB;

class NominationService
{
    protected NominationRepository $nominations;

    public function __construct(NominationRepository $nominations)
    {
        $this->nominations = $nominations;
    }

    public function all(array $with = [])
    {
        return $this->nominations->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->nominations->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->nominations->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        // If this is a supervisor nomination and exam details are provided,
        // create the Exam first inside a transaction and attach exam_id to nomination.
        return DB::transaction(function () use ($attributes) {
            $examId = $attributes['exam_id'] ?? null;

            // If no exam_id provided but exam_type/part present and nomination is supervisor, create an exam
            if (empty($examId) && ($attributes['nomination_type'] ?? null) === 'supervisor_nomination') {
                $examType = $attributes['exam_type'] ?? null;
                $part = $attributes['exam_part'] ?? null;

                if ($examType) {
                    $examData = [
                        'circle_id' => $attributes['circle_id'] ?? null,
                        'student_id' => $attributes['student_id'] ?? null,
                        'exam_type' => $examType,
                        // use today's Gregorian date for the created exam if not provided
                        'exam_date_g' => $attributes['exam_date_g'] ?? now()->toDateString(),
                        'exam_date_h' => $attributes['exam_date_h'] ?? null,
                        'total_points' => $attributes['total_points'] ?? null,
                        'total_grade' => $attributes['total_grade'] ?? null,
                        'remarks' => $attributes['notes'] ?? null,
                    ];

                    if ($examType === 'stage') {
                        $examData['stage'] = (int) $part;
                    } else {
                        $examData['juzz'] = (int) $part;
                    }

                    $exam = Exam::create($examData);
                        // create default exam items (q1..q6, t1, t2) with max_points = 10
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
                            ExamItem::insert($insert);
                        } catch (\Throwable $e) {
                            // Let transaction roll back by rethrowing
                            throw $e;
                        }
                    $examId = $exam->id;
                }
            }

            // attach exam_id to nomination attributes if created
            if ($examId) {
                $attributes['exam_id'] = $examId;
            }

            // remove transient exam_type/exam_part keys so they don't cause DB errors (nominations table doesn't store them)
            unset($attributes['exam_type'], $attributes['exam_part']);

            return $this->nominations->create($attributes);
        });
    }

    public function update($id, array $attributes)
    {
        return DB::transaction(function () use ($id, $attributes) {
            $nomination = $this->nominations->findOrFail($id);

            $examId = $attributes['exam_id'] ?? $nomination->exam_id ?? null;

            // If nomination is supervisor and exam details provided, create or update exam
            if (($attributes['nomination_type'] ?? $nomination->nomination_type) === 'supervisor_nomination') {
                $examType = $attributes['exam_type'] ?? null;
                $part = $attributes['exam_part'] ?? null;

                if ($examId) {
                    // update existing exam
                    $exam = Exam::find($examId);
                    if ($exam) {
                        $exam->exam_type = $examType ?? $exam->exam_type;
                        if (($examType ?? $exam->exam_type) === 'stage') {
                            $exam->stage = $part !== null ? (int) $part : $exam->stage;
                            $exam->juzz = null;
                        } else {
                            $exam->juzz = $part !== null ? (int) $part : $exam->juzz;
                            $exam->stage = null;
                        }
                        if (isset($attributes['exam_date_g'])) $exam->exam_date_g = $attributes['exam_date_g'];
                        if (isset($attributes['exam_date_h'])) $exam->exam_date_h = $attributes['exam_date_h'];
                        if (isset($attributes['total_points'])) $exam->total_points = $attributes['total_points'];
                        $exam->save();
                    }
                } elseif ($examType) {
                    // create a new exam and attach
                    $examData = [
                        'circle_id' => $attributes['circle_id'] ?? $nomination->circle_id,
                        'student_id' => $attributes['student_id'] ?? $nomination->student_id,
                        'exam_type' => $examType,
                        'exam_date_g' => $attributes['exam_date_g'] ?? now()->toDateString(),
                    ];
                    if ($examType === 'stage') {
                        $examData['stage'] = (int) $part;
                    } else {
                        $examData['juzz'] = (int) $part;
                    }
                    $exam = Exam::create($examData);
                    // create default exam items (q1..q6, t1, t2) with max_points = 10
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
                        ExamItem::insert($insert);
                    } catch (\Throwable $e) {
                        throw $e;
                    }
                    $examId = $exam->id;
                    $attributes['exam_id'] = $examId;
                }
            } else {
                // if nomination is no longer supervisor and had an exam linked, we may choose to keep or nullify exam_id
                // For now, keep existing exam_id unless explicitly set to null in attributes
            }

            // remove transient exam_type/exam_part keys
            unset($attributes['exam_type'], $attributes['exam_part']);

            return $this->nominations->update($id, $attributes);
        });
    }

    public function delete($id)
    {
        return $this->nominations->delete($id);
    }

    public function activate($id)
    {
        return $this->nominations->activate($id);
    }

    public function deactivate($id)
    {
        return $this->nominations->deactivate($id);
    }

    /**
     * Prepare data needed by create/edit pages.
     * Returns arrays: circles, students, plans, terms, nominators, nominationTypes
     *
     * @return array
     */
    public function prepareCreateData(): array
    {
        $circles = Circle::select('id', 'name')->orderBy('name')->get();

        // students don't have a `name` column; use the related user name instead
        // include student's current circle (from active enrollment) to allow frontend to auto-select circle
        // include student's current active enrollment and its circle name (if any)
        $students = Student::with(['user:id,name', 'enrollments' => function ($q) {
                $q->whereNull('left_at')->with('circle:id,name');
            }])->get()
            ->sortBy(function ($s) { return optional($s->user)->name ?? ''; })
            ->map(function ($s) {
                $active = $s->enrollments->first();
                $circleId = $active ? $active->circle_id : null;
                $circleName = $active && $active->circle ? $active->circle->name : null;
                return (object) ['id' => $s->id, 'name' => optional($s->user)->name ?? 'N/A', 'circle_id' => $circleId, 'circle_name' => $circleName];
            })
            ->values();

        // use academic years instead of plans (plans model doesn't have a name)
        $plans = \App\Models\AcademicYear::select('id', 'name')->orderBy('name')->get();
        $terms = Term::select('id', 'name')->orderBy('name')->get();

        // nominators: users who can nominate (admins/staff). For now return all users short list
        $nominators = User::select('id', 'name')->orderBy('name')->get();

        // nomination types available in code (keep in sync with migration/validation)
        $nominationTypes = [
            ['value' => 'supervisor_nomination', 'label' => 'Supervisor Nomination'],
            ['value' => 'ideal_student', 'label' => 'Ideal Student'],
            ['value' => 'reader_of_month', 'label' => 'Reader of the Month'],
        ];

        // nomination statuses
        $nominationStatuses = [
            ['value' => 'submitted'],
            ['value' => 'approved'],
            ['value' => 'rejected'],
        ];

        return compact('circles', 'students', 'plans', 'terms', 'nominators', 'nominationTypes', 'nominationStatuses');
    }
}
