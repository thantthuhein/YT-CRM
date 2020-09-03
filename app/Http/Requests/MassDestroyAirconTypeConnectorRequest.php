<?php

namespace App\Http\Requests;

use App\AirconTypeConnector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAirconTypeConnectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('aircon_type_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:aircon_type_connectors,id',
        ];
    }
}
