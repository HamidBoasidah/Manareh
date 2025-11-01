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
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage, ['circle' => ['id', 'name']]);
        $items->getCollection()->transform(function ($m) {
            return DailyStudySessionDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/DailyStudySession/Index', [
            'daily_study_sessions' => $items,
        ]);
    }

    public function create()
    {
        $circles = Circle::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Admin/DailyStudySession/Create', [
            'circles' => $circles,
        ]);
    }

    public function store(StoreDailyStudySessionRequest $request, DailyStudySessionService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.daily_study_sessions.index');
    }

    public function show(DailyStudySession $dailyStudySession)
    {
        $dailyStudySession->load(['circle:id,name', 'studies.student.user:id,name']);

        $dto = DailyStudySessionDTO::fromModel($dailyStudySession)->toArray();
        $studies = $dailyStudySession->studies
            ->map(fn ($study) => DailyStudyDTO::fromModel($study)->toArray());

        return Inertia::render('Admin/DailyStudySession/Show', [
            'daily_study_session' => $dto,
            'daily_studies' => $studies,
        ]);
    }

    public function edit(DailyStudySession $dailyStudySession)
    {
        $circles = Circle::select('id', 'name')->orderBy('name')->get();
        $dto = DailyStudySessionDTO::fromModel($dailyStudySession)->toArray();

        return Inertia::render('Admin/DailyStudySession/Edit', [
            'daily_study_session' => $dto,
            'circles' => $circles,
        ]);
    }

    public function update(UpdateDailyStudySessionRequest $request, DailyStudySessionService $service, DailyStudySession $dailyStudySession)
    {
        $service->update($dailyStudySession->id, $request->validated());
        return redirect()->route('admin.daily_study_sessions.index');
    }

    public function destroy(DailyStudySessionService $service, DailyStudySession $dailyStudySession)
    {
        $service->delete($dailyStudySession->id);
        return redirect()->route('admin.daily_study_sessions.index');
    }

    public function activate(DailyStudySessionService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Session activated successfully');
    }

    public function deactivate(DailyStudySessionService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Session deactivated successfully');
    }
}
