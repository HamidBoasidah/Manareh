<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExamItemRequest;
use App\Http\Requests\UpdateExamItemRequest;
use App\Services\ExamItemService;
use App\DTOs\ExamItemDTO;
use App\Models\ExamItem;
use Inertia\Inertia;

class ExamItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:exam_items.view')->only(['index', 'show']);
        $this->middleware('permission:exam_items.create')->only(['create', 'store']);
        $this->middleware('permission:exam_items.update')->only(['edit', 'update']);
        $this->middleware('permission:exam_items.delete')->only(['destroy']);
    }

    public function index(Request $request, ExamItemService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return ExamItemDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/ExamItem/Index', ['examItems' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/ExamItem/Create');
    }

    public function store(StoreExamItemRequest $request, ExamItemService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.exam_items.index');
    }

    public function show(ExamItem $examItem)
    {
        $dto = ExamItemDTO::fromModel($examItem)->toArray();
        return Inertia::render('Admin/ExamItem/Show', ['examItem' => $dto]);
    }

    public function edit(ExamItem $examItem)
    {
        $dto = ExamItemDTO::fromModel($examItem)->toArray();
        return Inertia::render('Admin/ExamItem/Edit', ['examItem' => $dto]);
    }

    public function update(UpdateExamItemRequest $request, ExamItemService $service, ExamItem $examItem)
    {
        $service->update($examItem->id, $request->validated());
        return redirect()->route('admin.exam_items.index');
    }

    public function destroy(ExamItemService $service, ExamItem $examItem)
    {
        $service->delete($examItem->id);
        return redirect()->route('admin.exam_items.index');
    }

    public function activate(ExamItemService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Exam item activated successfully');
    }

    public function deactivate(ExamItemService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Exam item deactivated successfully');
    }
}
