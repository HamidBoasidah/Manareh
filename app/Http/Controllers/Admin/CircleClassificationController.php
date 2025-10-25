<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCircleClassificationRequest;
use App\Http\Requests\UpdateCircleClassificationRequest;
use App\Services\CircleClassificationService;
use App\DTOs\CircleClassificationDTO;
use App\Models\CircleClassification;
use Inertia\Inertia;

class CircleClassificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:circle_classifications.view')->only(['index', 'show']);
        $this->middleware('permission:circle_classifications.create')->only(['create', 'store']);
        $this->middleware('permission:circle_classifications.update')->only(['edit', 'update']);
        $this->middleware('permission:circle_classifications.delete')->only(['destroy']);
    }

    public function index(Request $request, CircleClassificationService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return CircleClassificationDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/CircleClassification/Index', ['classifications' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/CircleClassification/Create');
    }

    public function store(StoreCircleClassificationRequest $request, CircleClassificationService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.circle_classifications.index');
    }

    public function show(CircleClassification $circleClassification)
    {
        $dto = CircleClassificationDTO::fromModel($circleClassification)->toArray();
        return Inertia::render('Admin/CircleClassification/Show', ['classification' => $dto]);
    }

    public function edit(CircleClassification $circleClassification)
    {
        $dto = CircleClassificationDTO::fromModel($circleClassification)->toArray();
        return Inertia::render('Admin/CircleClassification/Edit', ['classification' => $dto]);
    }

    public function update(UpdateCircleClassificationRequest $request, CircleClassificationService $service, CircleClassification $circleClassification)
    {
        $service->update($circleClassification->id, $request->validated());
        return redirect()->route('admin.circle_classifications.index');
    }

    public function destroy(CircleClassificationService $service, CircleClassification $circleClassification)
    {
        $service->delete($circleClassification->id);
        return redirect()->route('admin.circle_classifications.index');
    }

    public function activate(CircleClassificationService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Classification activated successfully');
    }

    public function deactivate(CircleClassificationService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Classification deactivated successfully');
    }
}
