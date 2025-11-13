<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notifications)
    {
        $this->middleware('permission:notifications.view')->only(['index', 'show']);
        $this->middleware('permission:notifications.update')->only(['markRead', 'markUnread', 'markAllRead']);
        $this->middleware('permission:notifications.delete')->only(['destroy']);
    }

    public function index(Request $request): Response
    {
        $filters = $request->only(['user_id', 'channel', 'status']);
        $filters['unread_only'] = $request->boolean('unread_only');
        $perPage = (int) $request->integer('per_page', 20);

        $notifications = $this->notifications->paginateForAdmin($perPage, $filters);

        return Inertia::render('Admin/Notification/Index', [
            'notifications' => $notifications,
            'filters' => $filters,
            'per_page' => $perPage,
        ]);
    }

    public function show(int $notificationId): JsonResponse
    {
        $notification = $this->notifications->getById($notificationId);

        return response()->json($notification);
    }

    public function destroy(int $notificationId): JsonResponse
    {
        $this->notifications->delete($notificationId);

        return response()->json(null, 204);
    }

    public function markRead(Request $request, int $notificationId): JsonResponse
    {
        $notification = $this->notifications->getById($notificationId);
        $userId = (int) ($notification['user']['id'] ?? 0);
        $updated = false;

        if ($userId > 0 && $request->user()?->id === $userId) {
            $this->notifications->markAsRead($userId, $notificationId);
            $updated = true;
        }

        return response()->json(['updated' => $updated]);
    }

    public function markUnread(Request $request, int $notificationId): JsonResponse
    {
        $notification = $this->notifications->getById($notificationId);
        $userId = (int) ($notification['user']['id'] ?? 0);
        $updated = false;

        if ($userId > 0 && $request->user()?->id === $userId) {
            $this->notifications->markAsUnread($userId, $notificationId);
            $updated = true;
        }

        return response()->json(['updated' => $updated]);
    }

    public function markAllRead(Request $request): JsonResponse
    {
        $userId = (int) $request->integer('user_id');
        $updated = false;

        if ($userId > 0 && $request->user()?->id === $userId) {
            $this->notifications->markAllAsRead($userId);
            $updated = true;
        }

        return response()->json(['updated' => $updated]);
    }
}
