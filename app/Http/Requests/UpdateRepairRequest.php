<?php

namespace App\Http\Requests;

use App\Repair;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRepairRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('repair_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'estimate_date' => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'team_type' => [
                'nullable',
                "in:". implode(',', array_keys(Repair::TEAM_TYPE_SELECT))
            ]
        ];
    }
}
