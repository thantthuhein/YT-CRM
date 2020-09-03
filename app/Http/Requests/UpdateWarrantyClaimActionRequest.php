<?php

namespace App\Http\Requests;

use App\WarrantyClaimAction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateWarrantyClaimActionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('warranty_claim_action_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'daikin_rep_name' => [
                'required',
                'string',
                'min:3'
            ],
            'daikin_rep_phone_number' => [
                'required',
                'min:7',
                config('panel.valid_phone_number')
            ],
            'estimate_date'           => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            // 'servicing_team_id' => [
            //     'required',
            //     'integer',
            //     'exists:servicing_teams,id'
            // ],
            'repair_team_id' => [
                'required',
                'integer',
            ],
            'actual_date'             => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'remark' => [
                'nullable',
                'string'
            ],
            'service_report_pdf_ywar_taw' => [
                'nullable',
                'array'
            ],
            'service_report_pdf_ywar_taw.*' => [
                'nullable', 
                'mimes:pdf', 
                'max:' . config('panel.pdf_max_size'),
            ],
            'service_report_pdf_daikin' => [
                'nullable',
                'array'
            ],
            'service_report_pdf_daikin.*' => [
                'nullable', 
                'mimes:pdf', 
                'max:' . config('panel.pdf_max_size'),
            ],
            'deliver_order_pdf' => [
                'nullable',
                'array'
            ],
            'deliver_order_pdf.*' => [
                'nullable', 
                'mimes:pdf', 
                'max:' . config('panel.pdf_max_size'),
            ],
        ];
    }
}
