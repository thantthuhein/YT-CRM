<?php

namespace App\Http\Requests;

use App\SaleContractPdf;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSaleContractPdfRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sale_contract_pdf_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'iteration' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
