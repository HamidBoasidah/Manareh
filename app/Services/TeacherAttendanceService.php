<?php

namespace App\Services;

use App\Repositories\TeacherAttendanceRepository;

class TeacherAttendanceService
{
    protected TeacherAttendanceRepository $attendances;

    public function __construct(TeacherAttendanceRepository $attendances)
    {
        $this->attendances = $attendances;
    }

    public function all(array $with = [])
    {
        return $this->attendances->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->attendances->paginate($perPage, $with);
    }

    public function paginateWithFilters(int $perPage = 15, array $filters = [], array $with = [])
    {
        return $this->attendances->paginateWithFilters($perPage, $filters, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->attendances->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->attendances->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->attendances->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->attendances->delete($id);
    }

    public function activate($id)
    {
        return $this->attendances->activate($id);
    }

    public function deactivate($id)
    {
        return $this->attendances->deactivate($id);
    }
}
