<?php

namespace App\Http\Requests;

use App\FollowUp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreFollowUpRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('follow_up_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'quotation_revision_id' => 'required',
            'remark' => 'nullable',
            'status' => 'required',
            'contact_person' => 'required',
            'follow_up_time' => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'contact_number' => 'required|min:7|' . config('panel.valid_phone_number'),
        ];
    }
}
