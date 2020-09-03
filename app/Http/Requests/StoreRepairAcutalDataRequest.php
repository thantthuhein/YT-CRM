<?php

namespace App\Http\Requests;

use App\Repair;
use Illuminate\Foundation\Http\FormRequest;

class StoreRepairAcutalDataRequest extends FormRequest
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
            'has_spare_part_replacement' => [
                'required',
                'in:'. implode(',', array_keys(Repair::HAS_SPARE_PART_REPLACEMENT_RADIO))
            ],
            'service_report_pdf' => [
                'sometimes',
                'required',
                'mimes:pdf',
                'max:'.config('panel.pdf_max_size')
            ],            
        ];
    }
}
