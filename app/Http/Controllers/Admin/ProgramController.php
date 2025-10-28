<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Services\ProgramService;
use App\DTOs\ProgramDTO;
use App\Models\Program;
use App\Models\Mosque;
use Inertia\Inertia;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:programs.view')->only(['index', 'show']);
        $this->middleware('permission:programs.create')->only(['create', 'store']);
        $this->middleware('permission:programs.update')->only(['edit', 'update']);
        $this->middleware('permission:programs.delete')->only(['destroy']);
    }

    public function index(Request $request, ProgramService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return ProgramDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/Program/Index', ['programs' => $items]);
    }

    public function create()
    {
        $mosques = Mosque::all(['id', 'name']);

        return Inertia::render('Admin/Program/Create', [
            'mosques' => $mosques,
        ]);
    }

    public function store(StoreProgramRequest $request, ProgramService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.programs.index');
    }

    public function show(Program $program)
    {
        $program->loadMissing('mosque:id,name');
        $dto = ProgramDTO::fromModel($program)->toArray();
        return Inertia::render('Admin/Program/Show', ['program' => $dto]);
    }

    public function edit(Program $program)
    {
        $program->loadMissing('mosque:id,name');
        $dto = ProgramDTO::fromModel($program)->toArray();
        $mosques = Mosque::all(['id', 'name']);

        return Inertia::render('Admin/Program/Edit', [
            'program' => $dto,
            'mosques' => $mosques,
        ]);
    }

    public function update(UpdateProgramRequest $request, ProgramService $service, Program $program)
    {
        $service->update($program->id, $request->validated());
        return redirect()->route('admin.programs.index');
    }

    public function destroy(ProgramService $service, Program $program)
    {
        $service->delete($program->id);
        return redirect()->route('admin.programs.index');
    }

    public function activate(ProgramService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Program activated successfully');
    }

    public function deactivate(ProgramService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Program deactivated successfully');
    }
}
