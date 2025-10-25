<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCertificateIssuedRequest;
use App\Http\Requests\UpdateCertificateIssuedRequest;
use App\Services\CertificateIssuedService;
use App\DTOs\CertificateIssuedDTO;
use App\Models\CertificateIssued;
use Inertia\Inertia;

class CertificateIssuedController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:certificate_issued.view')->only(['index', 'show']);
        $this->middleware('permission:certificate_issued.create')->only(['create', 'store']);
        $this->middleware('permission:certificate_issued.update')->only(['edit', 'update']);
        $this->middleware('permission:certificate_issued.delete')->only(['destroy']);
    }

    public function index(Request $request, CertificateIssuedService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return CertificateIssuedDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/CertificateIssued/Index', ['issued' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/CertificateIssued/Create');
    }

    public function store(StoreCertificateIssuedRequest $request, CertificateIssuedService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.certificate_issued.index');
    }

    public function show(CertificateIssued $certificateIssued)
    {
        $dto = CertificateIssuedDTO::fromModel($certificateIssued)->toArray();
        return Inertia::render('Admin/CertificateIssued/Show', ['issued' => $dto]);
    }

    public function edit(CertificateIssued $certificateIssued)
    {
        $dto = CertificateIssuedDTO::fromModel($certificateIssued)->toArray();
        return Inertia::render('Admin/CertificateIssued/Edit', ['issued' => $dto]);
    }

    public function update(UpdateCertificateIssuedRequest $request, CertificateIssuedService $service, CertificateIssued $certificateIssued)
    {
        $service->update($certificateIssued->id, $request->validated());
        return redirect()->route('admin.certificate_issued.index');
    }

    public function destroy(CertificateIssuedService $service, CertificateIssued $certificateIssued)
    {
        $service->delete($certificateIssued->id);
        return redirect()->route('admin.certificate_issued.index');
    }

    public function activate(CertificateIssuedService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Certificate issued activated successfully');
    }

    public function deactivate(CertificateIssuedService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Certificate issued deactivated successfully');
    }
}
