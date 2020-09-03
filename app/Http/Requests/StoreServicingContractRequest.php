<?php

namespace App\Http\Requests;

use App\ServicingContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServicingContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'inhouse_installation_id' => 'required',
            'interval' => 'required',
            'contract_start_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'contract_end_date'   => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'remark' => 'required',
        ];
    }
}
