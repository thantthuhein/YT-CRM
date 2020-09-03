<?php

namespace App\Http\Requests;

use App\WarrantyactionTeamConnector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWarrantyactionTeamConnectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('warrantyaction_team_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:warrantyaction_team_connectors,id',
        ];
    }
}
