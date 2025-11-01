<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDailyStudyRequest;
use App\Http\Requests\UpdateDailyStudyRequest;
use App\Services\DailyStudyService;
use App\DTOs\DailyStudyDTO;
use App\Models\DailyStudy;
use App\Models\QuranSura;
use Inertia\Inertia;

class DailyStudyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:daily_studies.view')->only(['index', 'show']);
        $this->middleware('permission:daily_studies.create')->only(['create', 'store']);
        $this->middleware('permission:daily_studies.update')->only(['edit', 'update']);
        $this->middleware('permission:daily_studies.delete')->only(['destroy']);
    }

    public function index(Request $request, DailyStudyService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return DailyStudyDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/DailyStudy/Index', ['dailyStudies' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/DailyStudy/Create');
    }

    public function store(StoreDailyStudyRequest $request, DailyStudyService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.daily_studies.index');
    }

    public function show(DailyStudy $dailyStudy)
    {
        $dto = DailyStudyDTO::fromModel($dailyStudy)->toArray();
        return Inertia::render('Admin/DailyStudy/Show', ['dailyStudy' => $dto]);
    }

    public function edit(DailyStudy $dailyStudy)
    {
        $dto = DailyStudyDTO::fromModel($dailyStudy)->toArray();
        $suras = QuranSura::select('id', 'name_ar', 'name_en')->orderBy('id')->get()->map(fn ($sura) => [
            'id' => $sura->id,
            'name_ar' => $sura->name_ar,
            'name_en' => $sura->name_en,
        ]);

        return Inertia::render('Admin/DailyStudy/Edit', [
            'dailyStudy' => $dto,
            'suras' => $suras,
        ]);
    }

    public function update(UpdateDailyStudyRequest $request, DailyStudyService $service, DailyStudy $dailyStudy)
    {
        $service->update($dailyStudy->id, $request->validated());
        return redirect()->route('admin.daily_studies.index');
    }

    public function destroy(DailyStudyService $service, DailyStudy $dailyStudy)
    {
        $service->delete($dailyStudy->id);
        return redirect()->route('admin.daily_studies.index');
    }

    public function activate(DailyStudyService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Daily study activated successfully');
    }

    public function deactivate(DailyStudyService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Daily study deactivated successfully');
    }
}
