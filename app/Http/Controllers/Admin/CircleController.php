<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCircleRequest;
use App\Http\Requests\UpdateCircleRequest;
use App\Services\CircleService;
use App\DTOs\CircleDTO;
use App\Models\Circle;
use App\Models\Mosque;
use App\Models\CircleClassification;
use App\Models\Student;
use Inertia\Inertia;

class CircleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:circles.view')->only(['index', 'show']);
        $this->middleware('permission:circles.create')->only(['create', 'store']);
        $this->middleware('permission:circles.update')->only(['edit', 'update']);
        $this->middleware('permission:circles.delete')->only(['destroy']);
    }

    public function index(Request $request, CircleService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return CircleDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Circle/Index', ['circles' => $items]);
    }

    public function create()
    {
        $mosques = Mosque::all(['id', 'name']);
        $classifications = CircleClassification::all(['id', 'name']);

        return Inertia::render('Admin/Circle/Create', [
            'mosques' => $mosques,
            'classifications' => $classifications,
        ]);
    }

    public function store(StoreCircleRequest $request, CircleService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.circles.index');
    }

    public function show(Circle $circle, CircleService $service)
    {
        $dto = \App\DTOs\CircleDTO::fromModel($circle)->toArray();
    
        return \Inertia\Inertia::render('Admin/Circle/Show', [
            'circle'         => $dto,
            'joinedStudents' => $service->getJoinedStudents($circle->id),
            'freeStudents'   => $service->getFreeStudents(),
            'canManageStudents' => auth()->user()?->can('circles.update') ?? false,
        ]);
    }


    public function edit(Circle $circle)
    {
        $dto = CircleDTO::fromModel($circle)->toArray();
        $mosques = Mosque::all(['id', 'name']);
        $classifications = CircleClassification::all(['id', 'name']);

        return Inertia::render('Admin/Circle/Edit', [
            'circle' => $dto,
            'mosques' => $mosques,
            'classifications' => $classifications,
        ]);
    }

    public function update(UpdateCircleRequest $request, CircleService $service, Circle $circle)
    {
        $service->update($circle->id, $request->validated());
        return redirect()->route('admin.circles.index');
    }

    public function destroy(CircleService $service, Circle $circle)
    {
        $service->delete($circle->id);
        return redirect()->route('admin.circles.index');
    }

    public function activate(CircleService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Circle activated successfully');
    }

    public function deactivate(CircleService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Circle deactivated successfully');
    }

    public function joinStudent(Request $request, CircleService $service, Circle $circle)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
        ]);

        $service->attachStudent($circle->id, (int) $validated['student_id']);

        return redirect()->route('admin.circles.show', $circle);
    }

    public function leaveStudent(CircleService $service, Circle $circle, Student $student)
    {
        $service->detachStudent($circle->id, $student->id);

        return redirect()->route('admin.circles.show', $circle);
    }
}
