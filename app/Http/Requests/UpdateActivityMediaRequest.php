<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mediaId = $this->route('activity_media') ? $this->route('activity_media')->id : null;

        return [
            'activity_id' => 'sometimes|required|exists:activities,id',
            'type' => 'sometimes|required|string|max:50',
            'path' => 'sometimes|required|string',
            'caption' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
