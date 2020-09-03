<?php

namespace App\Http\Requests;

use App\ServicingSetup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateServicingSetupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_setup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'estimated_date' => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'team_type' => [
                'required',
                "in:". implode(',', array_keys(ServicingSetup::TEAM_TYPE_SELECT))
            ]
        ];
    }
}
