<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\MessageTemplate;

class UpdateMessageTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $model = $this->route('message_template');
        $id = $model ? $model->id : null;
        $localeOptions = MessageTemplate::availableLocales();
        $mosqueId = $this->input('mosque_id', $model?->mosque_id);

        return [
            'mosque_id' => ['sometimes', 'nullable', 'exists:mosques,id'],
            'code' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('message_templates')->ignore($id)->where(function ($query) use ($mosqueId, $model) {
                    $channel = $this->input('channel', $model?->channel);
                    $locale = $this->input('locale', $model?->locale);

                    if ($mosqueId) {
                        $query->where('mosque_id', $mosqueId);
                    } else {
                        $query->whereNull('mosque_id');
                    }

                    return $query
                        ->where('channel', $channel)
                        ->where('locale', $locale);
                }),
            ],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'channel' => ['sometimes', 'required', Rule::in(MessageTemplate::CHANNELS)],
            'locale' => ['sometimes', 'required', Rule::in($localeOptions)],
            'subject' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'body' => ['sometimes', 'required', 'string'],
            'variables' => ['sometimes', 'nullable', 'array'],
            'variables.*.key' => ['required_with:variables', 'string', 'max:50', 'regex:/^[A-Za-z0-9_.\-]+$/'],
            'variables.*.label' => ['nullable', 'string', 'max:255'],
            'variables.*.type' => ['nullable', Rule::in(MessageTemplate::VARIABLE_TYPES)],
            'variables.*.required' => ['sometimes', 'boolean'],
            'variables.*.description' => ['nullable', 'string'],
            'sample_payload' => ['sometimes', 'nullable', 'array'],
            'extras' => ['sometimes', 'nullable', 'array'],
            'is_active' => ['sometimes', 'nullable', 'boolean'],
        ];
    }
}
