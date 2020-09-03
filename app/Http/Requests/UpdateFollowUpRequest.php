<?php

namespace App\Http\Requests;

use App\FollowUp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateFollowUpRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('follow_up_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            "remark" => "required",
            "follow_up_time" => "required",
            "contact_person" => "required",
            'contact_number' => 'required|min:7|' . config('panel.valid_phone_number'),
            "status" => "required",
        ];
    }
}
