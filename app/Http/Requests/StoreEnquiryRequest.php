<?php

namespace App\Http\Requests;

use Gate;
use App\Enquiry;
use Illuminate\Validation\Rule;
use App\Rules\NoEmptyStringArrayForPhone;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreEnquiryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('enquiry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            // 'customer_id'       => [
            //     'integer',
            //     'nullable'
            // ],
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
                'nullable',
                'string',
                new NoEmptyStringArrayForPhone
            ],
            'sale_engineer_id' => [
                'nullable'
            ]
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phones.required' => 'Phone Number Field is required',
            'airconTypes.required' => 'Aircon Types field is required',        
            'sale_engineer_id.required' => 'Sale Engineer field is required',       
            'receiver_name.required' => 'Receiver Name field is required',
        ];
    }
}
