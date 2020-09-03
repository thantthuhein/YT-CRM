<?php

namespace App\Http\Requests;

use App\AirconType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreAirconTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('aircon_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'parent' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
