<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTermRequest;
use App\Http\Requests\UpdateTermRequest;
use App\Services\TermService;
use App\DTOs\TermDTO;
use App\Models\Term;
use App\Models\AcademicYear;
use Inertia\Inertia;

class TermController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:terms.view')->only(['index', 'show']);
        $this->middleware('permission:terms.create')->only(['create', 'store']);
        $this->middleware('permission:terms.update')->only(['edit', 'update']);
        $this->middleware('permission:terms.delete')->only(['destroy']);
    }

    public function index(Request $request, TermService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return TermDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Term/Index', ['terms' => $items]);
    }

    public function create()
    {
        $academicYears = AcademicYear::all(['id', 'name']);
        return Inertia::render('Admin/Term/Create', [
            'academicYears' => $academicYears,
        ]);
    }

    public function store(StoreTermRequest $request, TermService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.terms.index');
    }

    public function show(Term $term)
    {
        $term->loadMissing('academicYear:id,name');
        $dto = TermDTO::fromModel($term)->toArray();
        return Inertia::render('Admin/Term/Show', ['term' => $dto]);
    }

    public function edit(Term $term)
    {
        $term->loadMissing('academicYear:id,name');
        $dto = TermDTO::fromModel($term)->toArray();
        $academicYears = AcademicYear::all(['id', 'name']);

        return Inertia::render('Admin/Term/Edit', [
            'term' => $dto,
            'academicYears' => $academicYears,
        ]);
    }

    public function update(UpdateTermRequest $request, TermService $service, Term $term)
    {
        $service->update($term->id, $request->validated());
        return redirect()->route('admin.terms.index');
    }

    public function destroy(TermService $service, Term $term)
    {
        $service->delete($term->id);
        return redirect()->route('admin.terms.index');
    }

    public function activate(TermService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Term activated successfully');
    }

    public function deactivate(TermService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Term deactivated successfully');
    }
}
