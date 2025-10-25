<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCertificateTemplateRequest;
use App\Http\Requests\UpdateCertificateTemplateRequest;
use App\Services\CertificateTemplateService;
use App\DTOs\CertificateTemplateDTO;
use App\Models\CertificateTemplate;
use Inertia\Inertia;

class CertificateTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:certificate_templates.view')->only(['index', 'show']);
        $this->middleware('permission:certificate_templates.create')->only(['create', 'store']);
        $this->middleware('permission:certificate_templates.update')->only(['edit', 'update']);
        $this->middleware('permission:certificate_templates.delete')->only(['destroy']);
    }

    public function index(Request $request, CertificateTemplateService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return CertificateTemplateDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/CertificateTemplate/Index', ['templates' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/CertificateTemplate/Create');
    }

    public function store(StoreCertificateTemplateRequest $request, CertificateTemplateService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.certificate_templates.index');
    }

    public function show(CertificateTemplate $certificateTemplate)
    {
        $dto = CertificateTemplateDTO::fromModel($certificateTemplate)->toArray();
        return Inertia::render('Admin/CertificateTemplate/Show', ['template' => $dto]);
    }

    public function edit(CertificateTemplate $certificateTemplate)
    {
        $dto = CertificateTemplateDTO::fromModel($certificateTemplate)->toArray();
        return Inertia::render('Admin/CertificateTemplate/Edit', ['template' => $dto]);
    }

    public function update(UpdateCertificateTemplateRequest $request, CertificateTemplateService $service, CertificateTemplate $certificateTemplate)
    {
        $service->update($certificateTemplate->id, $request->validated());
        return redirect()->route('admin.certificate_templates.index');
    }

    public function destroy(CertificateTemplateService $service, CertificateTemplate $certificateTemplate)
    {
        $service->delete($certificateTemplate->id);
        return redirect()->route('admin.certificate_templates.index');
    }

    public function activate(CertificateTemplateService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Certificate template activated successfully');
    }

    public function deactivate(CertificateTemplateService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Certificate template deactivated successfully');
    }
}
