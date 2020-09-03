<?php

namespace App\Http\Requests;

use App\Rules\NoEmptyStringArray;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubComTeamAssignRequest extends FormRequest
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
            'works' => [
                'required',
                'string',
                new NoEmptyStringArray
            ]
        ];
    }

    public function messages()
    {
        return [
            'works.*' => 'The Work Field is required',
        ];
    }
}
