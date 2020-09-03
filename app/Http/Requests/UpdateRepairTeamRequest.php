<?php

namespace App\Http\Requests;

use App\RepairTeam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRepairTeamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('repair_team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'phone_number' => [
                'nullable',
                'min:7',
                config('panel.valid_phone_number'),
            ],
            'man_power'    => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
