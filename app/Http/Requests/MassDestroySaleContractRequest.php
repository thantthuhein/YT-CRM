<?php

namespace App\Http\Requests;

use App\SaleContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySaleContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sale_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:sale_contracts,id',
        ];
    }
}
