<?php

namespace App\Http\Requests;

use App\ServicingSetup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServicingSetupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_setup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'project_id' => 'required',
            'is_major' => 'required',
            'servicing_team_id' => 'required',
            // 'subcom_team_id' => 'required',
            'estimated_date' => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'actual_date'    => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'request_type' => 'required',
            'team_type'      => 'required',
            'service_report_pdf' => 'required|mimes:pdf|max:' . config('panel.pdf_max_size'),
        ];
    }

    public function messages()
    {
        return [
            'is_major.required' => 'Major Field is required!',
        ];
    }
}
