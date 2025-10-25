<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDailyStudySessionRequest;
use App\Http\Requests\UpdateDailyStudySessionRequest;
use App\Services\DailyStudySessionService;
use App\DTOs\DailyStudySessionDTO;
use App\Models\DailyStudySession;
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
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return DailyStudySessionDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/DailyStudySession/Index', ['sessions' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/DailyStudySession/Create');
    }

    public function store(StoreDailyStudySessionRequest $request, DailyStudySessionService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.daily_study_sessions.index');
    }

    public function show(DailyStudySession $dailyStudySession)
    {
        $dto = DailyStudySessionDTO::fromModel($dailyStudySession)->toArray();
        return Inertia::render('Admin/DailyStudySession/Show', ['session' => $dto]);
    }

    public function edit(DailyStudySession $dailyStudySession)
    {
        $dto = DailyStudySessionDTO::fromModel($dailyStudySession)->toArray();
        return Inertia::render('Admin/DailyStudySession/Edit', ['session' => $dto]);
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
