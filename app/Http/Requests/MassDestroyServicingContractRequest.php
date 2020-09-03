<?php

namespace App\Http\Requests;

use App\ServicingContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServicingContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:servicing_contracts,id',
        ];
    }
}
