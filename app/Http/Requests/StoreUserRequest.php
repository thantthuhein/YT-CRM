<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'unique:users,phone_number'
            ],
            'email'        => [
                'nullable',
                'unique:users,email',
            ],
            'password'     => [
                'required',
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
