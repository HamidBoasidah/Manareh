<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreActivityMediaRequest;
use App\Http\Requests\UpdateActivityMediaRequest;
use App\Services\ActivityMediaService;
use App\DTOs\ActivityMediaDTO;
use App\Models\ActivityMedia;
use Inertia\Inertia;

class ActivityMediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:activity_media.view')->only(['index', 'show']);
        $this->middleware('permission:activity_media.create')->only(['create', 'store']);
        $this->middleware('permission:activity_media.update')->only(['edit', 'update']);
        $this->middleware('permission:activity_media.delete')->only(['destroy']);
    }

    public function index(Request $request, ActivityMediaService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return ActivityMediaDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/ActivityMedia/Index', ['activityMedia' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/ActivityMedia/Create');
    }

    public function store(StoreActivityMediaRequest $request, ActivityMediaService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.activity_media.index');
    }

    public function show(ActivityMedia $activityMedia)
    {
        $dto = ActivityMediaDTO::fromModel($activityMedia)->toArray();
        return Inertia::render('Admin/ActivityMedia/Show', ['activityMedia' => $dto]);
    }

    public function edit(ActivityMedia $activityMedia)
    {
        $dto = ActivityMediaDTO::fromModel($activityMedia)->toArray();
        return Inertia::render('Admin/ActivityMedia/Edit', ['activityMedia' => $dto]);
    }

    public function update(UpdateActivityMediaRequest $request, ActivityMediaService $service, ActivityMedia $activityMedia)
    {
        $service->update($activityMedia->id, $request->validated());
        return redirect()->route('admin.activity_media.index');
    }

    public function destroy(ActivityMediaService $service, ActivityMedia $activityMedia)
    {
        $service->delete($activityMedia->id);
        return redirect()->route('admin.activity_media.index');
    }

    public function activate(ActivityMediaService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Activity media activated successfully');
    }

    public function deactivate(ActivityMediaService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Activity media deactivated successfully');
    }
}
