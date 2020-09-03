<?php

namespace App\Http\Requests;

use App\FollowUp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFollowUpRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('follow_up_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:follow_ups,id',
        ];
    }
}
