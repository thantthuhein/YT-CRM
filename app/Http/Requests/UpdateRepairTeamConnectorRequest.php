<?php

namespace App\Http\Requests;

use App\RepairTeamConnector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRepairTeamConnectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('repair_team_connector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'morphable' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
