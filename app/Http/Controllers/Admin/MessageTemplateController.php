<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageTemplateRequest;
use App\Http\Requests\UpdateMessageTemplateRequest;
use App\Services\MessageTemplateService;
use App\DTOs\MessageTemplateDTO;
use App\Models\MessageTemplate;
use Inertia\Inertia;

class MessageTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:message_templates.view')->only(['index', 'show']);
        $this->middleware('permission:message_templates.create')->only(['create', 'store']);
        $this->middleware('permission:message_templates.update')->only(['edit', 'update']);
        $this->middleware('permission:message_templates.delete')->only(['destroy']);
    }

    public function index(Request $request, MessageTemplateService $service)
    {
        $perPage = $request->input('per_page', 10);
        $items = $service->paginate($perPage);
        $items->getCollection()->transform(function ($m) {
            return MessageTemplateDTO::fromModel($m)->toIndexArray();
        });
        return Inertia::render('Admin/MessageTemplate/Index', ['templates' => $items]);
    }

    public function create()
    {
        return Inertia::render('Admin/MessageTemplate/Create');
    }

    public function store(StoreMessageTemplateRequest $request, MessageTemplateService $service)
    {
        $service->create($request->validated());
        return redirect()->route('admin.message_templates.index');
    }

    public function show(MessageTemplate $messageTemplate)
    {
        $dto = MessageTemplateDTO::fromModel($messageTemplate)->toArray();
        return Inertia::render('Admin/MessageTemplate/Show', ['template' => $dto]);
    }

    public function edit(MessageTemplate $messageTemplate)
    {
        $dto = MessageTemplateDTO::fromModel($messageTemplate)->toArray();
        return Inertia::render('Admin/MessageTemplate/Edit', ['template' => $dto]);
    }

    public function update(UpdateMessageTemplateRequest $request, MessageTemplateService $service, MessageTemplate $messageTemplate)
    {
        $service->update($messageTemplate->id, $request->validated());
        return redirect()->route('admin.message_templates.index');
    }

    public function destroy(MessageTemplateService $service, MessageTemplate $messageTemplate)
    {
        $service->delete($messageTemplate->id);
        return redirect()->route('admin.message_templates.index');
    }

    public function activate(MessageTemplateService $service, $id)
    {
        $service->activate($id);
        return back()->with('success', 'Template activated successfully');
    }

    public function deactivate(MessageTemplateService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', 'Template deactivated successfully');
    }
}
