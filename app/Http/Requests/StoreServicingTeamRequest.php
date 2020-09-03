<?php

namespace App\Http\Requests;

use App\ServicingTeam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServicingTeamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                config('panel.valid_phone_number')
            ],
            'man_power'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
