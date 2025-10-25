<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePlanRequest;
use App\Services\PlanService;
use App\DTOs\PlanDTO;
use App\Models\Plan;
use Inertia\Inertia;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:plans.view')->only(['index', 'show']);
        $this->middleware('permission:plans.create')->only(['create', 'store']);
        $this->middleware('permission:plans.update')->only(['edit', 'update']);
        $this->middleware('permission:plans.delete')->only(['destroy']);
    }

    public function index(Request $request, PlanService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return PlanDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Plan/Index', ['plans' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/Plan/Create');
    }

    public function store(Request $request, PlanService $service)
    {
        $service->create($request->all());
        return redirect()->route('admin.plans.index');
    }

    public function show(Plan $plan)
    {
        $dto = PlanDTO::fromModel($plan)->toArray();
        return Inertia::render('Admin/Plan/Show', ['plan' => $dto]);
    }

    public function edit(Plan $plan)
    {
        $dto = PlanDTO::fromModel($plan)->toArray();
        return Inertia::render('Admin/Plan/Edit', ['plan' => $dto]);
    }

    public function update(UpdatePlanRequest $request, PlanService $service, Plan $plan)
    {
        $service->update($plan->id, $request->validated());
        return redirect()->route('admin.plans.index');
    }

    public function destroy(PlanService $service, Plan $plan)
    {
        $service->delete($plan->id);
        return redirect()->route('admin.plans.index');
    }

    public function activate(PlanService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Plan activated successfully');
    }

    public function deactivate(PlanService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Plan deactivated successfully');
    }
}
