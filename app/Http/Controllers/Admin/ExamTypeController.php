<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExamTypeRequest;
use App\Http\Requests\UpdateExamTypeRequest;
use App\Services\ExamTypeService;
use App\DTOs\ExamTypeDTO;
use App\Models\ExamType;
use Inertia\Inertia;

class ExamTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:exam_types.view')->only(['index', 'show']);
        $this->middleware('permission:exam_types.create')->only(['create', 'store']);
        $this->middleware('permission:exam_types.update')->only(['edit', 'update']);
        $this->middleware('permission:exam_types.delete')->only(['destroy']);
    }

    public function index(Request $request, ExamTypeService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return ExamTypeDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/ExamType/Index', ['examTypes' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/ExamType/Create');
    }

    public function store(StoreExamTypeRequest $request, ExamTypeService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.exam_types.index');
    }

    public function show(ExamType $examType)
    {
        $dto = ExamTypeDTO::fromModel($examType)->toArray();
        return Inertia::render('Admin/ExamType/Show', ['examType' => $dto]);
    }

    public function edit(ExamType $examType)
    {
        $dto = ExamTypeDTO::fromModel($examType)->toArray();
        return Inertia::render('Admin/ExamType/Edit', ['examType' => $dto]);
    }

    public function update(UpdateExamTypeRequest $request, ExamTypeService $service, ExamType $examType)
    {
        $service->update($examType->id, $request->validated());
        return redirect()->route('admin.exam_types.index');
    }

    public function destroy(ExamTypeService $service, ExamType $examType)
    {
        $service->delete($examType->id);
        return redirect()->route('admin.exam_types.index');
    }

    public function activate(ExamTypeService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Exam type activated successfully');
    }

    public function deactivate(ExamTypeService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Exam type deactivated successfully');
    }
}
