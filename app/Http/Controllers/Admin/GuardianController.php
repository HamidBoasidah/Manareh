<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGuardianRequest;
use App\Http\Requests\UpdateGuardianRequest;
use App\Services\GuardianService;
use App\DTOs\GuardianDTO;
use App\Models\Guardian;
use Inertia\Inertia;

class GuardianController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:guardians.view')->only(['index', 'show']);
        $this->middleware('permission:guardians.create')->only(['create', 'store']);
        $this->middleware('permission:guardians.update')->only(['edit', 'update']);
        $this->middleware('permission:guardians.delete')->only(['destroy']);
    }

    public function index(Request $request, GuardianService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return GuardianDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Guardian/Index', ['guardians' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/Guardian/Create');
    }

    public function store(StoreGuardianRequest $request, GuardianService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.guardians.index');
    }

    public function show(Guardian $guardian)
    {
        $dto = GuardianDTO::fromModel($guardian)->toArray();
        return Inertia::render('Admin/Guardian/Show', ['guardian' => $dto]);
    }

    public function edit(Guardian $guardian)
    {
        $dto = GuardianDTO::fromModel($guardian)->toArray();
        return Inertia::render('Admin/Guardian/Edit', ['guardian' => $dto]);
    }

    public function update(UpdateGuardianRequest $request, GuardianService $service, Guardian $guardian)
    {
        $service->update($guardian->id, $request->validated());
        return redirect()->route('admin.guardians.index');
    }

    public function destroy(GuardianService $service, Guardian $guardian)
    {
        $service->delete($guardian->id);
        return redirect()->route('admin.guardians.index');
    }

    public function activate(GuardianService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Guardian activated successfully');
    }

    public function deactivate(GuardianService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Guardian deactivated successfully');
    }
}
