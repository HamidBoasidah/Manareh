<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacherAttendanceRequest;
use App\Http\Requests\UpdateTeacherAttendanceRequest;
use App\Services\TeacherAttendanceService;
use App\DTOs\TeacherAttendanceDTO;
use App\Models\TeacherAttendance;
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
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return TeacherAttendanceDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/TeacherAttendance/Index', ['attendances' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/TeacherAttendance/Create');
    }

    public function store(StoreTeacherAttendanceRequest $request, TeacherAttendanceService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.teacher_attendances.index');
    }

    public function show(TeacherAttendance $teacherAttendance)
    {
        $dto = TeacherAttendanceDTO::fromModel($teacherAttendance)->toArray();
        return Inertia::render('Admin/TeacherAttendance/Show', ['attendance' => $dto]);
    }

    public function edit(TeacherAttendance $teacherAttendance)
    {
        $dto = TeacherAttendanceDTO::fromModel($teacherAttendance)->toArray();
        return Inertia::render('Admin/TeacherAttendance/Edit', ['attendance' => $dto]);
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
}
