<?php

namespace App\Http\Requests;

use App\ServicingSetup;
use Illuminate\Foundation\Http\FormRequest;

class StoreServicingSetupActualDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'actual_date' => [
                'required',
                'date_format:'. config('panel.date_format')
            ],
            'is_major' => [
                'required',
                'in:'. implode(',', array_keys(ServicingSetup::IS_MAJOR_RADIO))
            ],
            'service_report_pdf' => [
                'required',
                'mimes:pdf',
                'max:'.config('panel.pdf_max_size')
            ],
            // 'status' => [
            //     'required',
            //     'in:' . implode(',', array_keys(ServicingSetup::STATUS))
            // ],
            'remark' => [
                'nullable',
                'string'
            ]
        ];
    }
}
