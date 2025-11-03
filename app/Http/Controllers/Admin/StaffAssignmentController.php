<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStaffAssignmentRequest;
use App\Http\Requests\UpdateStaffAssignmentRequest;
use App\Services\StaffAssignmentService;
use App\DTOs\StaffAssignmentDTO;
use App\Models\StaffAssignment;
use App\Models\Circle;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;

class StaffAssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:staff_assignments.view')->only(['index', 'show']);
        $this->middleware('permission:staff_assignments.create')->only(['create', 'store']);
        $this->middleware('permission:staff_assignments.update')->only(['edit', 'update']);
        $this->middleware('permission:staff_assignments.delete')->only(['destroy']);
    }

    public function index(Request $request, StaffAssignmentService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return StaffAssignmentDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/StaffAssignment/Index', ['assignments' => $items]);
    }

    public function create(StaffAssignmentService $service)
    {
        $data = $service->prepareCreateData();
        return Inertia::render('Admin/StaffAssignment/Create', $data);
    }

    public function store(StoreStaffAssignmentRequest $request, StaffAssignmentService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.staff_assignments.index');
    }

    public function show(StaffAssignment $staffAssignment)
    {
        $dto = StaffAssignmentDTO::fromModel($staffAssignment)->toArray();
        return Inertia::render('Admin/StaffAssignment/Show', ['assignment' => $dto]);
    }

    public function edit(StaffAssignment $staffAssignment)
    {
        $dto = StaffAssignmentDTO::fromModel($staffAssignment)->toArray();
        return Inertia::render('Admin/StaffAssignment/Edit', ['assignment' => $dto]);
    }

    public function update(UpdateStaffAssignmentRequest $request, StaffAssignmentService $service, StaffAssignment $staffAssignment)
    {
        $service->update($staffAssignment->id, $request->validated());
        return redirect()->route('admin.staff_assignments.index');
    }

    public function destroy(StaffAssignmentService $service, StaffAssignment $staffAssignment)
    {
        $service->delete($staffAssignment->id);
        return redirect()->route('admin.staff_assignments.index');
    }

    public function activate(StaffAssignmentService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Assignment activated successfully');
    }

    public function deactivate(StaffAssignmentService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Assignment deactivated successfully');
    }

    /**
     * Unassign the active assignment for a given circle and role (teacher or supervisor).
     * Expects request input: circle_id, role (role slug)
     */
    public function unassign(Request $request, StaffAssignmentService $service)
    {
        $data = $request->validate([
            'circle_id' => 'required|integer|exists:circles,id',
            'role' => 'required|string',
        ]);

        $assignment = $service->unassignByCircleAndRole($data['circle_id'], $data['role']);

        if (! $assignment) {
            return back()->with('error', trans('staff_assignments.noStaffAssignment'));
        }

        return back()->with('success', trans('staff_assignments.assignmentDeletedSuccessfully'));
    }
}
