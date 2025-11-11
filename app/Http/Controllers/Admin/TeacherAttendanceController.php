<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacherAttendanceRequest;
use App\Http\Requests\UpdateTeacherAttendanceRequest;
use App\Services\TeacherAttendanceService;
use App\DTOs\TeacherAttendanceDTO;
use App\Models\TeacherAttendance;
use App\Models\Circle;
use App\Models\User;
use Inertia\Inertia;

class TeacherAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:teacher_attendances.view')->only(['index', 'show']);
        $this->middleware('permission:teacher_attendances.create')->only(['create', 'store']);
        $this->middleware('permission:teacher_attendances.update')->only(['edit', 'update']);
        $this->middleware('permission:teacher_attendances.delete')->only(['destroy']);
    }

    public function index(Request $request, TeacherAttendanceService $service)
    {
        $perPage = (int) $request->input('per_page', 12);
        $perPage = in_array($perPage, [12, 24, 48], true) ? $perPage : 12;

        $filters = collect($request->only([
            'search',
            'sort',
            'direction',
            'selected_date',
            'month',
        ]))->filter(function ($value) {
            if (is_string($value)) {
                return trim($value) !== '';
            }
            return !is_null($value);
        })->map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        })->toArray();

        $items = $service->paginateWithFilters($perPage, $filters);
        $items->getCollection()->transform(function ($m) {
            return TeacherAttendanceDTO::fromModel($m)->toIndexArray();
        });

        return Inertia::render('Admin/TeacherAttendance/Index', [
            'teacher_attendances' => $items,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/TeacherAttendance/Create', $this->formOptions());
    }

    public function store(StoreTeacherAttendanceRequest $request, TeacherAttendanceService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.teacher_attendances.index');
    }

    public function show(TeacherAttendance $teacherAttendance)
    {
        $dto = TeacherAttendanceDTO::fromModel($teacherAttendance)->toArray();
        return Inertia::render('Admin/TeacherAttendance/Show', ['teacher_attendance' => $dto]);
    }

    public function edit(TeacherAttendance $teacherAttendance)
    {
        $dto = TeacherAttendanceDTO::fromModel($teacherAttendance)->toArray();
        return Inertia::render('Admin/TeacherAttendance/Edit', array_merge(
            ['teacher_attendance' => $dto],
            $this->formOptions()
        ));
    }

    public function update(UpdateTeacherAttendanceRequest $request, TeacherAttendanceService $service, TeacherAttendance $teacherAttendance)
    {
        $service->update($teacherAttendance->id, $request->validated());
        return redirect()->route('admin.teacher_attendances.index');
    }

    public function destroy(TeacherAttendanceService $service, TeacherAttendance $teacherAttendance)
    {
        $service->delete($teacherAttendance->id);
        return redirect()->route('admin.teacher_attendances.index');
    }

    public function activate(TeacherAttendanceService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Attendance activated successfully');
    }

    public function deactivate(TeacherAttendanceService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Attendance deactivated successfully');
    }

    protected function formOptions(): array
    {
        $circles = Circle::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        $teachers = User::query()
            ->select(['id', 'name'])
            ->role('teacher')
            ->orderBy('name')
            ->get();

        $recorders = User::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        return [
            'circles' => $circles,
            'teachers' => $teachers,
            'recorders' => $recorders,
        ];
    }
}
