<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function __construct(private NotificationService $notifications)
    {
        $this->middleware('auth');
    }

    public function index(Request $request): JsonResponse
    {
        $userId = (int) $request->user()->id;
        $perPage = (int) $request->integer('per_page', 15);

        $paginator = $this->notifications->paginateForUser($userId, $perPage);

        return response()->json($paginator);
    }

    public function show(Request $request, int $notificationId): JsonResponse
    {
        $userId = (int) $request->user()->id;
        $notification = $this->notifications->getForUser($userId, $notificationId);

        return response()->json($notification->toArray());
    }

    public function markRead(Request $request, int $notificationId): JsonResponse
    {
        $userId = (int) $request->user()->id;
        $this->notifications->markAsRead($userId, $notificationId);

    return response()->noContent();
    }

    public function markUnread(Request $request, int $notificationId): JsonResponse
    {
        $userId = (int) $request->user()->id;
        $this->notifications->markAsUnread($userId, $notificationId);

    return response()->noContent();
    }

    public function markAllRead(Request $request): JsonResponse
    {
        $userId = (int) $request->user()->id;
        $this->notifications->markAllAsRead($userId);

    return response()->noContent();
    }

    public function markAllUnread(Request $request): JsonResponse
    {
        $userId = (int) $request->user()->id;
        $this->notifications->markAllAsUnread($userId);

    return response()->noContent();
    }
}
