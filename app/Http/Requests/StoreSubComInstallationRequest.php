<?php

namespace App\Http\Requests;

use App\SubComInstallation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSubComInstallationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sub_com_installation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'rating'          => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'completed_month' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'completed_year'  => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
