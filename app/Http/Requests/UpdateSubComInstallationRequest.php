<?php

namespace App\Http\Requests;

use App\SubComInstallation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateSubComInstallationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sub_com_installation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'rating'          => [
                'nullable',
                'integer',
                'min:1',
                'max:5',
            ],
            'completed_month' => [
                'integer',
                'min: 1',
                'max: 12',
                'nullable',
            ],
            'completed_year'  => [
                'min:4',
                'max:4',
                'nullable',
            ],
        ];
    }
}
