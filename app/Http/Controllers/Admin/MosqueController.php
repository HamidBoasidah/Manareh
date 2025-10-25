<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMosqueRequest;
use App\Http\Requests\UpdateMosqueRequest;
use App\Services\MosqueService;
use App\DTOs\MosqueDTO;
use App\Models\Mosque;
use Inertia\Inertia;

class MosqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:mosques.view')->only(['index', 'show']);
        $this->middleware('permission:mosques.create')->only(['create', 'store']);
        $this->middleware('permission:mosques.update')->only(['edit', 'update']);
        $this->middleware('permission:mosques.delete')->only(['destroy']);
    }

    public function index(Request $request, MosqueService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return MosqueDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Mosque/Index', ['mosques' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/Mosque/Create');
    }

    public function store(StoreMosqueRequest $request, MosqueService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.mosques.index');
    }

    public function show(Mosque $mosque)
    {
        $dto = MosqueDTO::fromModel($mosque)->toArray();
        return Inertia::render('Admin/Mosque/Show', ['mosque' => $dto]);
    }

    public function edit(Mosque $mosque)
    {
        $dto = MosqueDTO::fromModel($mosque)->toArray();
        return Inertia::render('Admin/Mosque/Edit', ['mosque' => $dto]);
    }

    public function update(UpdateMosqueRequest $request, MosqueService $service, Mosque $mosque)
    {
        $service->update($mosque->id, $request->validated());
        return redirect()->route('admin.mosques.index');
    }

    public function destroy(MosqueService $service, Mosque $mosque)
    {
        $service->delete($mosque->id);
        return redirect()->route('admin.mosques.index');
    }

    public function activate(MosqueService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Mosque activated successfully');
    }

    public function deactivate(MosqueService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Mosque deactivated successfully');
    }
}
