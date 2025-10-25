<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Services\EnrollmentService;
use App\DTOs\EnrollmentDTO;
use App\Models\Enrollment;
use Inertia\Inertia;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:enrollments.view')->only(['index', 'show']);
        $this->middleware('permission:enrollments.create')->only(['create', 'store']);
        $this->middleware('permission:enrollments.update')->only(['edit', 'update']);
        $this->middleware('permission:enrollments.delete')->only(['destroy']);
    }

    public function index(Request $request, EnrollmentService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return EnrollmentDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Enrollment/Index', ['enrollments' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/Enrollment/Create');
    }

    public function store(StoreEnrollmentRequest $request, EnrollmentService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.enrollments.index');
    }

    public function show(Enrollment $enrollment)
    {
        $dto = EnrollmentDTO::fromModel($enrollment)->toArray();
        return Inertia::render('Admin/Enrollment/Show', ['enrollment' => $dto]);
    }

    public function edit(Enrollment $enrollment)
    {
        $dto = EnrollmentDTO::fromModel($enrollment)->toArray();
        return Inertia::render('Admin/Enrollment/Edit', ['enrollment' => $dto]);
    }

    public function update(UpdateEnrollmentRequest $request, EnrollmentService $service, Enrollment $enrollment)
    {
        $service->update($enrollment->id, $request->validated());
        return redirect()->route('admin.enrollments.index');
    }

    public function destroy(EnrollmentService $service, Enrollment $enrollment)
    {
        $service->delete($enrollment->id);
        return redirect()->route('admin.enrollments.index');
    }

    public function activate(EnrollmentService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Enrollment activated successfully');
    }

    public function deactivate(EnrollmentService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Enrollment deactivated successfully');
    }
}
