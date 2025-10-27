<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Services\ActivityService;
use App\DTOs\ActivityDTO;
use App\Models\Activity;
use App\Models\Mosque;
use Inertia\Inertia;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:activities.view')->only(['index', 'show']);
        $this->middleware('permission:activities.create')->only(['create', 'store']);
        $this->middleware('permission:activities.update')->only(['edit', 'update']);
        $this->middleware('permission:activities.delete')->only(['destroy']);
    }

    public function index(Request $request, ActivityService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return ActivityDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Activity/Index', ['activities' => $items]);
    }

    public function create()
    {
        // need mosques for selection
        // mosques have a single 'name' field (no name_ar/name_en)
        $mosques = Mosque::all(['id', 'name']);
        return Inertia::render('Admin/Activity/Create', [
            'mosques' => $mosques,
        ]);
    }

    public function store(StoreActivityRequest $request, ActivityService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.activities.index');
    }

    public function show(Activity $activity)
    {
        $dto = ActivityDTO::fromModel($activity)->toArray();
        return Inertia::render('Admin/Activity/Show', ['activity' => $dto]);
    }

    public function edit(Activity $activity)
    {
        $dto = ActivityDTO::fromModel($activity)->toArray();
        // need mosques for selection
        // mosques have a single 'name' field (no name_ar/name_en)
        $mosques = Mosque::all(['id', 'name']);
        return Inertia::render('Admin/Activity/Edit', [
            'activity' => $dto,
            'mosques' => $mosques,
        ]);
    }

    public function update(UpdateActivityRequest $request, ActivityService $service, Activity $activity)
    {
        $service->update($activity->id, $request->validated());
        return redirect()->route('admin.activities.index');
    }

    public function destroy(ActivityService $service, Activity $activity)
    {
        $service->delete($activity->id);
        return redirect()->route('admin.activities.index');
    }

    public function activate(ActivityService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Activity activated successfully');
    }

    public function deactivate(ActivityService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Activity deactivated successfully');
    }
}
