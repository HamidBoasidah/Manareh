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
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return ExamDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Exam/Index', ['exams' => $items]);
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

    public function show(Exam $exam)
    {
        $dto = ExamDTO::fromModel($exam)->toArray();
        return Inertia::render('Admin/Exam/Show', ['exam' => $dto]);
    }

    public function edit(Exam $exam)
    {
        $dto = ExamDTO::fromModel($exam)->toArray();
        return Inertia::render('Admin/Exam/Edit', ['exam' => $dto]);
    }

    public function update(UpdateExamRequest $request, ExamService $service, Exam $exam)
    {
        $service->update($exam->id, $request->validated());
        return redirect()->route('admin.exams.index');
    }

    public function destroy(ExamService $service, Exam $exam)
    {
        $service->delete($exam->id);
        return redirect()->route('admin.exams.index');
    }

    public function activate(ExamService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Exam activated successfully');
    }

    public function deactivate(ExamService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Exam deactivated successfully');
    }
}
