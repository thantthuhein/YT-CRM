<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataAFterCompletedRequest extends FormRequest
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
             'tc_time'                      => [
                 'required',
                'date_format:' . config('panel.date_format'),
            ],
            'hand_over_date'               => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            // 'actual_installation_report_pdf'=> [
            //     'required',
            //     'mimes:pdf'
            // ],
            'handover_pdfs.equp_list' => [
                'nullable',
                'mimes:pdf',
                'max:'. config('panel.pdf_max_size')
            ],
            'handover_pdfs.as_build' => [
                'nullable',
                'mimes:pdf',
                'max:'. config('panel.pdf_max_size')
            ],
            'handover_pdfs.test_report' => [
                'nullable',
                'array'
            ],
            'handover_pdfs.test_report.*' => [
                'nullable',
                'mimes:pdf',
                'max:'. config('panel.pdf_max_size')
            ],
            'handover_pdfs.operation_mainteneance' => [
                'nullable',
                'mimes:pdf',
                'max:'. config('panel.pdf_max_size')
            ],
            'handover_pdfs.warran_cert' => [
                'nullable',
                'mimes:pdf',
                'max:'. config('panel.pdf_max_size')
            ],
        ];
    }
}
