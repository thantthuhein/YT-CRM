<?php

namespace App\Http\Requests;

use App\ServicingTeamConnector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServicingTeamConnectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_team_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:servicing_team_connectors,id',
        ];
    }
}
