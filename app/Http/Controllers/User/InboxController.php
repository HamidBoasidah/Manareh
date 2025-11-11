<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\DTOs\NotificationDTO;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InboxController extends Controller
{
    public function __construct()
    {
        // تأكد أن المستخدم مسجّل دخول
        $this->middleware('auth');
    }

    /**
     * عرض قائمة الرسائل (البريد الوارد) للمستخدم الحالي.
     */
    public function index(Request $request, NotificationService $service)
    {
        $user = $request->user();
        $perPage = (int) $request->input('per_page', 15);

        $items = $service->inboxForUser($user->id, $perPage, ['template']);

        $items->getCollection()->transform(function ($m) {
            return NotificationDTO::fromModel($m)->toIndexArray();
        });

        $unreadCount = $service->unreadCountForUser($user->id);

        return Inertia::render('User/Inbox/Index', [
            'notifications' => $items,
            'unread_count'  => $unreadCount,
        ]);
    }

    /**
     * عرض رسالة واحدة (مع تعليمها مقروءة).
     */
    public function show(Request $request, NotificationService $service, int $id)
    {
        $user = $request->user();

        $notification = $service->find($id, ['template']);

        // ضمان أن الإشعار يخص هذا المستخدم
        if ($notification->user_id !== $user->id) {
            abort(403);
        }

        // If request expects JSON (AJAX master/detail), mark as read and return JSON payload.
        if ($request->wantsJson()) {
            if (is_null($notification->read_at)) {
                $service->markAsRead($notification->id);
                $notification->refresh();
            }

            $dto = NotificationDTO::fromModel($notification)->toArray();
            return response()->json($dto);
        }

        // Default: render Inertia page (navigating to /inbox/{id}).
        if (is_null($notification->read_at)) {
            $service->markAsRead($notification->id);
            $notification->refresh();
        }

        $dto = NotificationDTO::fromModel($notification)->toArray();

        return Inertia::render('User/Inbox/Show', [
            'notification' => $dto,
        ]);
    }

    /**
     * تعليم رسالة كمقروءة بدون فتح صفحة منفصلة (Ajax من الواجهة).
     */
    public function markAsRead(Request $request, NotificationService $service, int $id)
    {
        $user = $request->user();
        $notification = $service->find($id);

        if ($notification->user_id !== $user->id) {
            abort(403);
        }

        $service->markAsRead($notification->id);

        return back();
    }

    /**
     * تعليم جميع رسائل المستخدم كمقروءة.
     */
    public function markAllAsRead(Request $request, NotificationService $service)
    {
        $user = $request->user();
        $service->markAllAsReadForUser($user->id);

        return back();
    }
}
