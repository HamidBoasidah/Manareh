<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\MessageTemplate;

class StoreMessageTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $localeOptions = MessageTemplate::availableLocales();
        $mosqueId = $this->input('mosque_id');

        return [
            'mosque_id' => ['nullable', 'exists:mosques,id'],
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('message_templates')->where(function ($query) use ($mosqueId) {
                    if ($mosqueId) {
                        $query->where('mosque_id', $mosqueId);
                    } else {
                        $query->whereNull('mosque_id');
                    }

                    return $query
                        ->where('channel', $this->input('channel'))
                        ->where('locale', $this->input('locale'));
                }),
            ],
            'name' => ['required', 'string', 'max:255'],
            'channel' => ['required', Rule::in(MessageTemplate::CHANNELS)],
            'locale' => ['required', Rule::in($localeOptions)],
            'subject' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'variables' => ['nullable', 'array'],
            'variables.*.key' => ['required_with:variables', 'string', 'max:50', 'regex:/^[A-Za-z0-9_.\-]+$/'],
            'variables.*.label' => ['nullable', 'string', 'max:255'],
            'variables.*.type' => ['nullable', Rule::in(MessageTemplate::VARIABLE_TYPES)],
            'variables.*.required' => ['sometimes', 'boolean'],
            'variables.*.description' => ['nullable', 'string'],
            'sample_payload' => ['nullable', 'array'],
            'extras' => ['nullable', 'array'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
