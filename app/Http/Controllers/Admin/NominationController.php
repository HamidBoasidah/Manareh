<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNominationRequest;
use App\Http\Requests\UpdateNominationRequest;
use App\Services\NominationService;
use App\DTOs\NominationDTO;
use App\Models\Nomination;
use Inertia\Inertia;

class NominationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:nominations.view')->only(['index', 'show']);
        $this->middleware('permission:nominations.create')->only(['create', 'store']);
        $this->middleware('permission:nominations.update')->only(['edit', 'update']);
        $this->middleware('permission:nominations.delete')->only(['destroy']);
    }

    public function index(Request $request, NominationService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return NominationDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Nomination/Index', ['nominations' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/Nomination/Create');
    }

    public function store(StoreNominationRequest $request, NominationService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.nominations.index');
    }

    public function show(Nomination $nomination)
    {
        $dto = NominationDTO::fromModel($nomination)->toArray();
        return Inertia::render('Admin/Nomination/Show', ['nomination' => $dto]);
    }

    public function edit(Nomination $nomination)
    {
        $dto = NominationDTO::fromModel($nomination)->toArray();
        return Inertia::render('Admin/Nomination/Edit', ['nomination' => $dto]);
    }

    public function update(UpdateNominationRequest $request, NominationService $service, Nomination $nomination)
    {
        $service->update($nomination->id, $request->validated());
        return redirect()->route('admin.nominations.index');
    }

    public function destroy(NominationService $service, Nomination $nomination)
    {
        $service->delete($nomination->id);
        return redirect()->route('admin.nominations.index');
    }

    public function activate(NominationService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Nomination activated successfully');
    }

    public function deactivate(NominationService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Nomination deactivated successfully');
    }
}
