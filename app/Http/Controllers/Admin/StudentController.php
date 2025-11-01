<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\StudentService;
use App\DTOs\StudentDTO;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\Mosque;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:students.view')->only(['index', 'show']);
        $this->middleware('permission:students.create')->only(['create', 'store']);
        $this->middleware('permission:students.update')->only(['edit', 'update']);
        $this->middleware('permission:students.delete')->only(['destroy']);
    }

    public function index(Request $request, StudentService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return StudentDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Student/Index', ['students' => $items]);
    }

    public function create()
    {
        $guardians = Guardian::all(['id', 'name']);
        $mosques = Mosque::all(['id', 'name']);
        return Inertia::render('Admin/Student/Create', [
            'guardians' => $guardians,
            'mosques' => $mosques
        ]);
    }

    public function store(StoreStudentRequest $request, StudentService $service)
    {
        $service->create($request->validated());

        return redirect()
            ->route('admin.students.index')
            ->with('success', __('students.studentCreatedSuccessfully'));
    }

    public function show(Student $student)
    {
        $dto = StudentDTO::fromModel($student)->toArray();
        return Inertia::render('Admin/Student/Show', ['student' => $dto]);
    }

    public function edit(Student $student)
    {
        $dto = StudentDTO::fromModel($student)->toArray();
        return Inertia::render('Admin/Student/Edit', ['student' => $dto]);
    }

    public function update(UpdateStudentRequest $request, StudentService $service, Student $student)
    {
        $service->update($student->id, $request->validated());

        return redirect()
            ->route('admin.students.index')
            ->with('success', __('students.studentUpdatedSuccessfully'));
    }

    public function destroy(StudentService $service, Student $student)
    {
        $service->delete($student->id);

        return redirect()
            ->route('admin.students.index')
            ->with('success', __('students.studentDeletedSuccessfully'));
    }

    public function activate(StudentService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Student activated successfully');
    }

    public function deactivate(StudentService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Student deactivated successfully');
    }
}
