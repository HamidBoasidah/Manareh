<?php

namespace App\Services;

use App\Repositories\ExamRepository;

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
        return $this->exams->update($id, $attributes);
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
