<?php

namespace App\Http\Requests;

use App\ServicingComplementary;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServicingComplementaryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_complementary_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:servicing_complementaries,id',
        ];
    }
}
