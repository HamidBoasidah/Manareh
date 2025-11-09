<?php

namespace App\Services;

use App\Repositories\ExamRepository;
use Illuminate\Support\Facades\DB;
use App\Models\ExamItem;

class ExamService
{
    protected ExamRepository $exams;

    public function __construct(ExamRepository $exams)
    {
        $this->exams = $exams;
    }

    public function all(array $with = [])
    {
        return $this->exams->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->exams->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->exams->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->exams->create($attributes);
    }

    public function update($id, array $attributes)
    {
        // Support bulk update of exam items together with exam fields in a single transaction.
        $items = $attributes['items'] ?? null;
        // remove items from the attributes passed to the repository update
        if (array_key_exists('items', $attributes)) {
            unset($attributes['items']);
        }

        return DB::transaction(function () use ($id, $attributes, $items) {
            // update exam fields (if any)
            $exam = $this->exams->findOrFail($id);
            if (!empty($attributes)) {
                // use repository update so file-handling and other hooks remain consistent
                $this->exams->update($id, $attributes);
                // reload model
                $exam = $this->exams->findOrFail($id);
            }

            // if items provided, update them and recalculate totals
            if (is_array($items)) {
                foreach ($items as $it) {
                    if (!isset($it['id'])) continue;
                    // ensure the item belongs to this exam before updating
                    $examItem = ExamItem::where('id', $it['id'])->where('exam_id', $id)->first();
                    if ($examItem) {
                        $score = $it['score_points'] ?? 0;
                        $examItem->score_points = $score;
                        $examItem->save();
                    }
                }

                // recompute total points from items
                $total = ExamItem::where('exam_id', $id)->sum('score_points');
                $exam->total_points = $total;
                // prefer provided total_grade if passed earlier via attributes
                if (array_key_exists('total_grade', $attributes)) {
                    $exam->total_grade = $attributes['total_grade'];
                }
                $exam->save();
            }

            return $this->exams->findOrFail($id);
        });
    }

    public function delete($id)
    {
        return $this->exams->delete($id);
    }

    public function activate($id)
    {
        return $this->exams->activate($id);
    }

    public function deactivate($id)
    {
        return $this->exams->deactivate($id);
    }
}
