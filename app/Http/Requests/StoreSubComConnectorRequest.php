<?php

namespace App\Http\Requests;

use App\SubComConnector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSubComConnectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sub_com_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
