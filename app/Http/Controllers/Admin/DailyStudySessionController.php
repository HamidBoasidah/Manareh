<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDailyStudySessionRequest;
use App\Http\Requests\UpdateDailyStudySessionRequest;
use App\Services\DailyStudySessionService;
use App\DTOs\DailyStudySessionDTO;
use App\DTOs\DailyStudyDTO;
use App\Models\DailyStudySession;
use App\Models\Circle;
use App\Models\StaffAssignment;
use App\Models\User;
use Inertia\Inertia;

class DailyStudySessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:daily_study_sessions.view')->only(['index', 'show']);
        $this->middleware('permission:daily_study_sessions.create')->only(['create', 'store']);
        $this->middleware('permission:daily_study_sessions.update')->only(['edit', 'update']);
        $this->middleware('permission:daily_study_sessions.delete')->only(['destroy']);
    }

    public function index(Request $request, DailyStudySessionService $service)
    {
        $perPage = (int) $request->input('per_page', 10);
        $user = $request->user();

        if ($user && $user->hasRole('teacher')) {
            $items = $service->paginateForUser($user, $perPage, ['circle' => ['id', 'name']]);
        } else {
            $items = $service->paginate($perPage, ['circle' => ['id', 'name']]);
        }
        $items->getCollection()->transform(function ($m) {
            return DailyStudySessionDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/DailyStudySession/Index', [
            'daily_study_sessions' => $items,
        ]);
    }

    public function create(Request $request)
    {
        $circles = $this->availableCirclesForUser($request->user());

        return Inertia::render('Admin/DailyStudySession/Create', [
            'circles' => $circles,
        ]);
    }

    public function store(StoreDailyStudySessionRequest $request, DailyStudySessionService $service)
    {
        $data = $request->validated();
        $this->assertCanManageCircle($request->user(), (int) $data['circle_id']);
        $service->create($data);
        return redirect()->route('admin.daily_study_sessions.index');
    }

    public function show(Request $request, DailyStudySessionService $service, DailyStudySession $dailyStudySession)
    {
        $this->assertCanAccessSession($request->user(), $service, $dailyStudySession);
        $dailyStudySession->load(['circle:id,name', 'studies.student.user:id,name']);

        $dto = DailyStudySessionDTO::fromModel($dailyStudySession)->toArray();
        $studies = $dailyStudySession->studies
            ->map(fn ($study) => DailyStudyDTO::fromModel($study)->toArray());

        return Inertia::render('Admin/DailyStudySession/Show', [
            'daily_study_session' => $dto,
            'daily_studies' => $studies,
        ]);
    }

    public function edit(Request $request, DailyStudySessionService $service, DailyStudySession $dailyStudySession)
    {
        $this->assertCanAccessSession($request->user(), $service, $dailyStudySession);
        $circles = $this->availableCirclesForUser($request->user());
        $dto = DailyStudySessionDTO::fromModel($dailyStudySession)->toArray();

        return Inertia::render('Admin/DailyStudySession/Edit', [
            'daily_study_session' => $dto,
            'circles' => $circles,
        ]);
    }

    public function update(UpdateDailyStudySessionRequest $request, DailyStudySessionService $service, DailyStudySession $dailyStudySession)
    {
        $this->assertCanAccessSession($request->user(), $service, $dailyStudySession);
        $data = $request->validated();
        if (array_key_exists('circle_id', $data)) {
            $this->assertCanManageCircle($request->user(), (int) $data['circle_id']);
        }
        $service->update($dailyStudySession->id, $data);
        return redirect()->route('admin.daily_study_sessions.index');
    }

    public function destroy(Request $request, DailyStudySessionService $service, DailyStudySession $dailyStudySession)
    {
        $this->assertCanAccessSession($request->user(), $service, $dailyStudySession);
        $service->delete($dailyStudySession->id);
        return redirect()->route('admin.daily_study_sessions.index');
    }

    public function activate(Request $request, DailyStudySessionService $service, $id)
    {
        $session = $service->find($id);
        $this->assertCanAccessSession($request->user(), $service, $session);
        $service->activate($id);
        return back()->with('success', 'Session activated successfully');
    }

    public function deactivate(Request $request, DailyStudySessionService $service, $id)
    {
        $session = $service->find($id);
        $this->assertCanAccessSession($request->user(), $service, $session);
        $service->deactivate($id);
        return back()->with('success', 'Session deactivated successfully');
    }

    protected function availableCirclesForUser(?User $user)
    {
        $circleIds = $this->permittedCircleIds($user);

        $query = Circle::select('id', 'name')->orderBy('name');

        if (is_array($circleIds)) {
            if (empty($circleIds)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('id', $circleIds);
            }
        }

        return $query->get();
    }

    protected function assertCanAccessSession(?User $user, DailyStudySessionService $service, DailyStudySession $session): void
    {
        if (! $user) {
            abort(403);
        }

        if ($user->hasRole('super-admin')) {
            return;
        }

        if ($user->hasRole('teacher') && ! $service->userCanAccessSession($user, $session)) {
            abort(403, __('messages.notAuthorized'));
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

        if ($user->hasRole('teacher')) {
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

        if ($user->hasRole('teacher')) {
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
