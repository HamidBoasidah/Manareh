<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Services\NotificationService;
use App\DTOs\NotificationDTO;
use App\Models\Notification;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:notifications.view')->only(['index', 'show']);
        $this->middleware('permission:notifications.create')->only(['create', 'store']);
        $this->middleware('permission:notifications.update')->only(['edit', 'update']);
        $this->middleware('permission:notifications.delete')->only(['destroy']);
    }

    public function index(Request $request, NotificationService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return NotificationDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Notification/Index', ['notifications' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/Notification/Create');
    }

    public function store(StoreNotificationRequest $request, NotificationService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.notifications.index');
    }

    public function show(Notification $notification)
    {
        $dto = NotificationDTO::fromModel($notification)->toArray();
        return Inertia::render('Admin/Notification/Show', ['notification' => $dto]);
    }

    public function edit(Notification $notification)
    {
        $dto = NotificationDTO::fromModel($notification)->toArray();
        return Inertia::render('Admin/Notification/Edit', ['notification' => $dto]);
    }

    public function update(UpdateNotificationRequest $request, NotificationService $service, Notification $notification)
    {
        $service->update($notification->id, $request->validated());
        return redirect()->route('admin.notifications.index');
    }

    public function destroy(NotificationService $service, Notification $notification)
    {
        $service->delete($notification->id);
        return redirect()->route('admin.notifications.index');
    }

    public function activate(NotificationService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Notification activated successfully');
    }

    public function deactivate(NotificationService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Notification deactivated successfully');
    }
}
