<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $activityId = $this->route('activity') ? $this->route('activity')->id : null;

        return [
            'mosque_id' => 'sometimes|required|exists:mosques,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'activity_date_g' => 'nullable|date',
            'activity_date_h' => 'nullable|string|max:50',
            'place' => 'nullable|string|max:255',
            'media' => 'nullable|array',
            'media.*' => 'file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'removed_media_ids' => 'nullable|array',
            'removed_media_ids.*' => 'integer|exists:activity_media,id',
            'created_by' => 'nullable|exists:users,id',
            'is_active' => 'nullable|boolean',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
