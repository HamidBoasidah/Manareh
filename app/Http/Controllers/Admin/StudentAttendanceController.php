<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentAttendanceRequest;
use App\Http\Requests\UpdateStudentAttendanceRequest;
use App\Services\StudentAttendanceService;
use App\DTOs\StudentAttendanceDTO;
use App\Models\StudentAttendance;
use Inertia\Inertia;

class StudentAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:student_attendances.view')->only(['index', 'show']);
        $this->middleware('permission:student_attendances.create')->only(['create', 'store']);
        $this->middleware('permission:student_attendances.update')->only(['edit', 'update']);
        $this->middleware('permission:student_attendances.delete')->only(['destroy']);
    }

    public function index(Request $request, StudentAttendanceService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return StudentAttendanceDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/StudentAttendance/Index', ['attendances' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/StudentAttendance/Create');
    }

    public function store(StoreStudentAttendanceRequest $request, StudentAttendanceService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.student_attendances.index');
    }

    public function show(StudentAttendance $studentAttendance)
    {
        $dto = StudentAttendanceDTO::fromModel($studentAttendance)->toArray();
        return Inertia::render('Admin/StudentAttendance/Show', ['attendance' => $dto]);
    }

    public function edit(StudentAttendance $studentAttendance)
    {
        $dto = StudentAttendanceDTO::fromModel($studentAttendance)->toArray();
        return Inertia::render('Admin/StudentAttendance/Edit', ['attendance' => $dto]);
    }

    public function update(UpdateStudentAttendanceRequest $request, StudentAttendanceService $service, StudentAttendance $studentAttendance)
    {
        $service->update($studentAttendance->id, $request->validated());
        return redirect()->route('admin.student_attendances.index');
    }

    public function destroy(StudentAttendanceService $service, StudentAttendance $studentAttendance)
    {
        $service->delete($studentAttendance->id);
        return redirect()->route('admin.student_attendances.index');
    }

    public function activate(StudentAttendanceService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Attendance activated successfully');
    }

    public function deactivate(StudentAttendanceService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Attendance deactivated successfully');
    }
}
