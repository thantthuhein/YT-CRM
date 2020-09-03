<?php

namespace App\Http\Requests;

use App\Quotation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateQuotationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('quotation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'quotation_number_type' => 'required', 
            'number' => 'required|digits_between:4,4', 
            'year' => 'required|min:4|max:4', 
            'customer_address' => 'required',
            'status' => 'required',
            'quotation_pdf' => 'nullable|mimes:pdf|max:' . config('panel.pdf_max_size'),
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'The number field is required.',
            'number.digits_between' => 'Invalid Format.',
            'year.max' => 'Invalid Format',
            'year.min' => 'Invalid Format',
        ];
    }
}
