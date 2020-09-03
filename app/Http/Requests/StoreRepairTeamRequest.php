<?php

namespace App\Http\Requests;

use App\RepairTeam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRepairTeamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('repair_team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'leader_name' => [
                'required',
                'string'
            ],
            'phone_number' => [
                'nullable',
                'min:7',
                config('panel.valid_phone_number'),
            ],
            'man_power'    => [
                'required',
                'integer',
                'min:1',
            ],
            'is_active' => [
                'required'
            ]
        ];
    }
}
