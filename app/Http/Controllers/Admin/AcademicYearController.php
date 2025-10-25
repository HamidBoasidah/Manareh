<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAcademicYearRequest;
use App\Http\Requests\UpdateAcademicYearRequest;
use App\Services\AcademicYearService;
use App\DTOs\AcademicYearDTO;
use App\Models\AcademicYear;
use Inertia\Inertia;

class AcademicYearController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:academic_years.view')->only(['index', 'show']);
        $this->middleware('permission:academic_years.create')->only(['create', 'store']);
        $this->middleware('permission:academic_years.update')->only(['edit', 'update']);
        $this->middleware('permission:academic_years.delete')->only(['destroy']);
    }

    public function index(Request $request, AcademicYearService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return AcademicYearDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/AcademicYear/Index', ['academicYears' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/AcademicYear/Create');
    }

    public function store(StoreAcademicYearRequest $request, AcademicYearService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.academic_years.index');
    }

    public function show(AcademicYear $academicYear)
    {
        $dto = AcademicYearDTO::fromModel($academicYear)->toArray();
        return Inertia::render('Admin/AcademicYear/Show', ['academicYear' => $dto]);
    }

    public function edit(AcademicYear $academicYear)
    {
        $dto = AcademicYearDTO::fromModel($academicYear)->toArray();
        return Inertia::render('Admin/AcademicYear/Edit', ['academicYear' => $dto]);
    }

    public function update(UpdateAcademicYearRequest $request, AcademicYearService $service, AcademicYear $academicYear)
    {
        $service->update($academicYear->id, $request->validated());
        return redirect()->route('admin.academic_years.index');
    }

    public function destroy(AcademicYearService $service, AcademicYear $academicYear)
    {
        $service->delete($academicYear->id);
        return redirect()->route('admin.academic_years.index');
    }

    public function activate(AcademicYearService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Academic year activated successfully');
    }

    public function deactivate(AcademicYearService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Academic year deactivated successfully');
    }
}
