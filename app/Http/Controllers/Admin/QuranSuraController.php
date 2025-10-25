<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuranSuraRequest;
use App\Http\Requests\UpdateQuranSuraRequest;
use App\Services\QuranSuraService;
use App\DTOs\QuranSuraDTO;
use App\Models\QuranSura;
use Inertia\Inertia;

class QuranSuraController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:quran_suras.view')->only(['index', 'show']);
        $this->middleware('permission:quran_suras.create')->only(['create', 'store']);
        $this->middleware('permission:quran_suras.update')->only(['edit', 'update']);
        $this->middleware('permission:quran_suras.delete')->only(['destroy']);
    }

    public function index(Request $request, QuranSuraService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return QuranSuraDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/QuranSura/Index', ['suras' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/QuranSura/Create');
    }

    public function store(StoreQuranSuraRequest $request, QuranSuraService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.quran_suras.index');
    }

    public function show(QuranSura $quranSura)
    {
        $dto = QuranSuraDTO::fromModel($quranSura)->toArray();
        return Inertia::render('Admin/QuranSura/Show', ['sura' => $dto]);
    }

    public function edit(QuranSura $quranSura)
    {
        $dto = QuranSuraDTO::fromModel($quranSura)->toArray();
        return Inertia::render('Admin/QuranSura/Edit', ['sura' => $dto]);
    }

    public function update(UpdateQuranSuraRequest $request, QuranSuraService $service, QuranSura $quranSura)
    {
        $service->update($quranSura->id, $request->validated());
        return redirect()->route('admin.quran_suras.index');
    }

    public function destroy(QuranSuraService $service, QuranSura $quranSura)
    {
        $service->delete($quranSura->id);
        return redirect()->route('admin.quran_suras.index');
    }

    public function activate(QuranSuraService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Sura activated successfully');
    }

    public function deactivate(QuranSuraService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Sura deactivated successfully');
    }
}
