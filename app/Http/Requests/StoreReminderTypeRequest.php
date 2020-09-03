<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReminderTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'type' => "required|string",
            // 'action' => "required|string",
            'role_id' => "sometimes|required|array",
            'role_id.*' => "sometimes|required|integer|exists:roles,id",
            // 'reminder_model' => 'nullable|string',
            'description' => 'nullable|string'
        ];
    }
}
