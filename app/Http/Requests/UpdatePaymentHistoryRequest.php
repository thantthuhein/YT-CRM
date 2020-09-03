<?php

namespace App\Http\Requests;

use App\PaymentHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdatePaymentHistoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('payment_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'sale_contract_id'  => [
                'required',
                'integer',
            ],
            'payment_step_from' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'payment_step_to'   => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
