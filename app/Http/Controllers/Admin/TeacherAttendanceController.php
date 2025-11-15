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
use App\Models\StaffAssignment;
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

        $user = $request->user();
        $circleIds = $this->permittedCircleIds($user);
        if (is_array($circleIds)) {
            $filters['circle_ids'] = $circleIds;
        }

        $items = $service->paginateWithFilters($perPage, $filters);
        $items->getCollection()->transform(function ($m) {
            return TeacherAttendanceDTO::fromModel($m)->toIndexArray();
        });

        return Inertia::render('Admin/TeacherAttendance/Index', [
            'teacher_attendances' => $items,
            'filters' => $filters,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Admin/TeacherAttendance/Create', $this->formOptions($request->user()));
    }

    public function store(StoreTeacherAttendanceRequest $request, TeacherAttendanceService $service)
    {
        $data = $request->validated();
        $this->assertCanManageCircle($request->user(), (int) $data['circle_id']);
        $service->create($data);
        return redirect()->route('admin.teacher_attendances.index');
    }

    public function show(Request $request, TeacherAttendance $teacherAttendance)
    {
        $this->assertCanAccessAttendance($request->user(), $teacherAttendance);
        $dto = TeacherAttendanceDTO::fromModel($teacherAttendance)->toArray();
        return Inertia::render('Admin/TeacherAttendance/Show', ['teacher_attendance' => $dto]);
    }

    public function edit(Request $request, TeacherAttendance $teacherAttendance)
    {
        $this->assertCanAccessAttendance($request->user(), $teacherAttendance);
        $dto = TeacherAttendanceDTO::fromModel($teacherAttendance)->toArray();
        return Inertia::render('Admin/TeacherAttendance/Edit', array_merge(
            ['teacher_attendance' => $dto],
            $this->formOptions($request->user())
        ));
    }

    public function update(UpdateTeacherAttendanceRequest $request, TeacherAttendanceService $service, TeacherAttendance $teacherAttendance)
    {
        $this->assertCanAccessAttendance($request->user(), $teacherAttendance);
        $data = $request->validated();
        if (array_key_exists('circle_id', $data)) {
            $this->assertCanManageCircle($request->user(), (int) $data['circle_id']);
        }
        $service->update($teacherAttendance->id, $data);
        return redirect()->route('admin.teacher_attendances.index');
    }

    public function destroy(Request $request, TeacherAttendanceService $service, TeacherAttendance $teacherAttendance)
    {
        $this->assertCanAccessAttendance($request->user(), $teacherAttendance);
        $service->delete($teacherAttendance->id);
        return redirect()->route('admin.teacher_attendances.index');
    }

    public function activate(Request $request, TeacherAttendanceService $service, $id)
    {
        $attendance = $service->find($id);
        $this->assertCanAccessAttendance($request->user(), $attendance);
        $service->activate($id);
        return back()->with('success', 'Attendance activated successfully');
    }

    public function deactivate(Request $request, TeacherAttendanceService $service, $id)
    {
        $attendance = $service->find($id);
        $this->assertCanAccessAttendance($request->user(), $attendance);
        $service->deactivate($id);
        return back()->with('success', 'Attendance deactivated successfully');
    }

    protected function formOptions(?User $user): array
    {
        $circleIds = $this->permittedCircleIds($user);

        $circlesQuery = Circle::query()
            ->select(['id', 'name'])
            ->orderBy('name');

        if (is_array($circleIds)) {
            if (empty($circleIds)) {
                $circlesQuery->whereRaw('1 = 0');
            } else {
                $circlesQuery->whereIn('id', $circleIds);
            }
        }
        $circles = $circlesQuery->get();

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

    protected function assertCanAccessAttendance(?User $user, TeacherAttendance $attendance): void
    {
        if (! $user) {
            abort(403);
        }

        if ($user->hasRole('super-admin')) {
            return;
        }

        if ($user->hasAnyRole(['supervisor_tarbawi', 'supervisor_edu'])) {
            $circleIds = $this->permittedCircleIds($user);
            if (empty($circleIds) || ! in_array((int) $attendance->circle_id, $circleIds, true)) {
                abort(403, __('messages.notAuthorized'));
            }
        }
    }

    protected function assertCanManageCircle(?User $user, int $circleId): void
    {
        if (! $user) {
            abort(403);
        }

        if ($user->hasRole('super-admin')) {
            return;
        }

        if ($user->hasAnyRole(['supervisor_tarbawi', 'supervisor_edu'])) {
            $circleIds = $this->permittedCircleIds($user);
            if (empty($circleIds) || ! in_array($circleId, $circleIds, true)) {
                abort(403, __('messages.notAuthorized'));
            }
        }
    }

    protected function permittedCircleIds(?User $user): ?array
    {
        if (! $user) {
            return [];
        }

        if ($user->hasRole('super-admin')) {
            return null;
        }

        if ($user->hasAnyRole(['supervisor_tarbawi', 'supervisor_edu'])) {
            return StaffAssignment::query()
                ->where('user_id', $user->id)
                ->where('is_active', true)
                ->pluck('circle_id')
                ->filter()
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all();
        }

        return null;
    }
}
