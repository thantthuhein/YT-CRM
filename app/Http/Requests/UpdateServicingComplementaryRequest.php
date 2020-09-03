<?php

namespace App\Http\Requests;

use App\ServicingComplementary;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateServicingComplementaryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_complementary_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'first_maintenance_date'  => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'second_maintenance_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
