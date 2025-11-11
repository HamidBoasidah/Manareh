<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageTemplateRequest;
use App\Http\Requests\UpdateMessageTemplateRequest;
use App\Services\MessageTemplateService;
use App\DTOs\MessageTemplateDTO;
use App\Models\MessageTemplate;
use App\Models\Mosque;
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
        $perPage = (int) $request->input('per_page', 10);
        $filters = $request->only(['search', 'channel', 'locale', 'mosque_id', 'is_active', 'sort', 'direction']);

        $items = $service->paginateWithFilters($filters, $perPage);
        $items->getCollection()->transform(fn ($m) => MessageTemplateDTO::fromModel($m)->toIndexArray());

        return Inertia::render('Admin/MessageTemplate/Index', [
            'message_templates' => $items,
            'filters' => $filters,
            'options' => [
                'channels' => $service->channels(),
                'locales' => MessageTemplate::availableLocales(),
            ],
        ]);
    }

    public function create()
    {
        $mosques = Mosque::query()->select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Admin/MessageTemplate/Create', [
            'options' => [
                'channels' => MessageTemplate::CHANNELS,
                'locales' => MessageTemplate::availableLocales(),
                'variable_types' => MessageTemplate::VARIABLE_TYPES,
                'mosques' => $mosques,
            ],
        ]);
    }

    public function store(StoreMessageTemplateRequest $request, MessageTemplateService $service)
    {
        $service->create($request->validated());

        return redirect()->route('admin.message_templates.index');
    }

    public function show(MessageTemplate $messageTemplate)
    {
        $dto = MessageTemplateDTO::fromModel($messageTemplate)->toArray();

        return Inertia::render('Admin/MessageTemplate/Show', [
            'message_template' => $dto,
            'options' => [
                'channels' => MessageTemplate::CHANNELS,
                'locales' => MessageTemplate::availableLocales(),
                'variable_types' => MessageTemplate::VARIABLE_TYPES,
            ],
        ]);
    }

    public function edit(MessageTemplate $messageTemplate)
    {
        $dto = MessageTemplateDTO::fromModel($messageTemplate)->toArray();
        $mosques = Mosque::query()->select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Admin/MessageTemplate/Edit', [
            'message_template' => $dto,
            'options' => [
                'channels' => MessageTemplate::CHANNELS,
                'locales' => MessageTemplate::availableLocales(),
                'variable_types' => MessageTemplate::VARIABLE_TYPES,
                'mosques' => $mosques,
            ],
        ]);
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
        return back()->with('success', __('messages.activatedSuccessfully') ?? 'Template activated successfully');
    }

    public function deactivate(MessageTemplateService $service, $id)
    {
        $service->deactivate($id);
        return back()->with('success', __('messages.deactivatedSuccessfully') ?? 'Template deactivated successfully');
    }
}
