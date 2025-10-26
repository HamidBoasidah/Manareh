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

    public function index(Request $request, MosqueService $mosqueService)
    {
        $perPage = $request->input('per_page', 10);
        $mosques = $mosqueService->paginate($perPage);
        $mosques->getCollection()->transform(function ($mosque) {
            return MosqueDTO::fromModel($mosque)->toIndexArray();
        });
        return Inertia::render('Admin/Mosque/Index', [
            'mosques' => $mosques
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Mosque/Create');
    }

    public function store(StoreMosqueRequest $request, MosqueService $mosqueService)
    {
        $data = $request->validated();
        $mosqueService->create($data);
        return redirect()->route('admin.mosques.index');
    }

    public function show(Mosque $mosque)
    {
        $dto = MosqueDTO::fromModel($mosque)->toArray();
        return Inertia::render('Admin/Mosque/Show', [
            'mosque' => $dto,
        ]);
    }

    public function edit(Mosque $mosque)
    {
        $dto = MosqueDTO::fromModel($mosque)->toArray();
        return Inertia::render('Admin/Mosque/Edit', [
            'mosque' => $dto,
        ]);
    }

    public function update(UpdateMosqueRequest $request, MosqueService $mosqueService, Mosque $mosque)
    {
        $data = $request->validated();
        $mosqueService->update($mosque->id, $data);
        return redirect()->route('admin.mosques.index');
    }

    public function destroy(MosqueService $mosqueService, Mosque $mosque)
    {
        $mosqueService->delete($mosque->id);
        return redirect()->route('admin.mosques.index');
    }

    public function activate(MosqueService $mosqueService, $id)
    {
        $mosqueService->activate($id);
        return back()->with('success', 'Mosque activated successfully');
    }

    public function deactivate(MosqueService $mosqueService, $id)
    {
        $mosqueService->deactivate($id);
        return back()->with('success', 'Mosque deactivated successfully');
    }
}
