<?php

namespace App\Http\Requests;

use App\SaleContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateSaleContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sale_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'morphable'            => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'has_installation'     => [
                'required',
            ],
            'payment_terms'        => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'current_payment_step' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
