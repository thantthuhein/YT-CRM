<?php

namespace App\Http\Requests;

use Gate;
use App\Enquiry;
use Illuminate\Validation\Rule;
use App\Rules\NoEmptyStringArrayForPhone;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateEnquiryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('enquiry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }
    
    public function rules()
    {
        return [
            'enquiries_type_id' => [
                'required',
                'integer',
            ],
            'type_of_sales_id'  => [
                'required',
                'integer',
            ],
            'customer_id'       => [
                'integer',
                'nullable'
            ],
            'airconTypes'       =>[
                'required',
            ],
            'has_future_action' => [
                'required'
            ],
            'has_installation' => [
                'required'
            ],
            'status' => [
                'required'
            ],
            'receiver_name' => [
                'required'
            ],
            'phones' => [
                'required',
                'string',
                new NoEmptyStringArrayForPhone
            ],
            'sale_engineer_id' => [
                'nullable'
            ]
        ];
    }
    
    public function messages()
    {
        return [
            'phones.required' => 'Phone Field is required',
        ];
    }
}
