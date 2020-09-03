<?php

namespace App\Http\Requests;

use App\TypeOfSale;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTypeOfSaleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('type_of_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:type_of_sales,id',
        ];
    }
}
