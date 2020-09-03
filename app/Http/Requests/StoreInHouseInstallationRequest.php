<?php

namespace App\Http\Requests;

use App\InHouseInstallation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreInHouseInstallationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('in_house_installation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'site_engineer_id' => [
                'required',
                'integer',
                'exists:users,id'
            ],
            'estimate_start_date'          => [
                'nullable',
                'date_format:' . config('panel.date_format'),
            ],
            'estimate_end_date'            => [
                'nullable',
                'date_format:' . config('panel.date_format'),
            ],
            'actual_start_date'            => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'actual_end_date'              => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'servicing_team_id'            => [
                'required', 'array'
            ],
            'servicing_team_id.*'            => [
                'required', 'integer'
            ]
            // 'tc_time'                      => [
            //     'date_format:' . config('panel.date_format'),
            //     'nullable',
            // ],
            // 'hand_over_date'               => [
            //     'date_format:' . config('panel.date_format'),
            //     'nullable',
            // ],
            // 'service_manager_approve_date' => [
            //     'date_format:' . config('panel.date_format'),
            //     'nullable',
            // ],
            // 'project_manager_approve_date' => [
            //     'date_format:' . config('panel.date_format'),
            //     'nullable',
            // ],
        ];
    }
}
