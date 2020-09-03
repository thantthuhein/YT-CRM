<?php

namespace App\Http\Requests;

use App\User;
use Gate;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{    
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'         => [
                'required',
            ],
            'phone_number' => [
                'required',
                'min:7',
                config('panel.valid_phone_number'),
                Rule::unique('users')->ignore($this->user->id),
            ],
            'email'        => [
                'nullable',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'roles.*'      => [
                'integer',
            ],
            'roles'        => [
                'required',
                'array',
            ],
        ];
    }
}
