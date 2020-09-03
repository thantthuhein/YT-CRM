<?php

namespace App\Http\Requests;

use App\Repair;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRepairRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('repair_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'estimate_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'actual_date'   => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
