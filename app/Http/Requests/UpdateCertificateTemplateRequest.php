<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCertificateTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $templateId = $this->route('certificate_template') ? $this->route('certificate_template')->id : null;

        return [
            'mosque_id' => 'sometimes|required|exists:mosques,id',
            'name' => 'sometimes|required|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'html_template' => 'nullable|string',
            'variables' => 'nullable|array',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
