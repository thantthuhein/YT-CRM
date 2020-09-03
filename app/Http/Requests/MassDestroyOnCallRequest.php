<?php

namespace App\Http\Requests;

use App\OnCall;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOnCallRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('on_call_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:on_calls,id',
        ];
    }
}
