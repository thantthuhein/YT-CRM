<?php

namespace App\Http\Requests;

use App\OnCall;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreOnCallRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('on_call_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id'
            ],
            'service_type_id' => [
                'required',
                'integer',
                'exists:service_types,id'
            ],
            'tentative_date' => [
                'required',
                'date_format:'. config('panel.date_format')
            ],
            'remark' => [
                'required',
                'string'
            ],
            'sale_contract_id' => [
                'required',
                'integer',
                'exists:sale_contracts,id'
            ]
        ];
    }
}


