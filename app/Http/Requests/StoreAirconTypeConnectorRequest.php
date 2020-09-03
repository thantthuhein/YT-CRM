<?php

namespace App\Http\Requests;

use App\AirconTypeConnector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreAirconTypeConnectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('aircon_type_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'aircon_types.*' => [
                'integer',
            ],
            'aircon_types'   => [
                'array',
            ],
        ];
    }
}
