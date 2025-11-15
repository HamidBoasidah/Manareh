<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Services\ExamService;
use App\DTOs\ExamDTO;
use App\Models\Exam;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:exams.view')->only(['index', 'show']);
        $this->middleware('permission:exams.create')->only(['create', 'store']);
        $this->middleware('permission:exams.update')->only(['edit', 'update']);
        $this->middleware('permission:exams.delete')->only(['destroy']);
    }

    public function index(Request $request, ExamService $service)
    {
        $perPage = (int) $request->input('per_page', 10);
        $user = $request->user();
        if (! $user) {
            abort(403);
        }
        $isSuperAdmin = $user?->hasRole('super-admin') ?? false;

        $items = $isSuperAdmin
            ? $service->paginate($perPage)
            : $service->paginateForUser($user, $perPage);

        $items->getCollection()->transform(function ($m) {
            return ExamDTO::fromModel($m)->toIndexArray();
        });

        return Inertia::render('Admin/Exam/Index', [
            'exams' => $items,
            'is_super_admin' => $isSuperAdmin,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Exam/Create');
    }

    public function store(StoreExamRequest $request, ExamService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.exams.index');
    }

    public function show(Request $request, ExamService $service, Exam $exam)
    {
        $this->assertExamAccess($request->user(), $service, $exam);
        $dto = ExamDTO::fromModel($exam)->toArray();
        return Inertia::render('Admin/Exam/Show', ['exam' => $dto]);
    }

    public function edit(Request $request, ExamService $service, Exam $exam)
    {
        $this->assertExamAccess($request->user(), $service, $exam);
        $dto = ExamDTO::fromModel($exam)->toArray();
        return Inertia::render('Admin/Exam/Edit', ['exam' => $dto]);
    }

    public function update(UpdateExamRequest $request, ExamService $service, Exam $exam)
    {
        $this->assertExamAccess($request->user(), $service, $exam);
        $service->update($exam->id, $request->validated());
        return redirect()->route('admin.exams.index');
    }

    public function destroy(Request $request, ExamService $service, Exam $exam)
    {
        $this->assertExamAccess($request->user(), $service, $exam);
        $service->delete($exam->id);
        return redirect()->route('admin.exams.index');
    }

    public function activate(Request $request, ExamService $service, $id)
    {
        $exam = $service->find($id);
        $this->assertExamAccess($request->user(), $service, $exam);
        $service->activate($id);
        return back()->with('success', 'Exam activated successfully');
    }

    public function deactivate(Request $request, ExamService $service, $id)
    {
        $exam = $service->find($id);
        $this->assertExamAccess($request->user(), $service, $exam);
        $service->deactivate($id);
        return back()->with('success', 'Exam deactivated successfully');
    }

    protected function assertExamAccess($user, ExamService $service, Exam $exam): void
    {
        if (! $user) {
            abort(403);
        }

        if (! $service->userCanAccessExam($user, $exam)) {
            abort(403, __('messages.notAuthorized'));
        }
    }
}
