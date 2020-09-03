<?php

namespace App\Http\Requests;

use App\WarrantyClaimAction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreWarrantyClaimActionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('warranty_claim_action_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'daikin_rep_name' => [
                'required',
                'string',
                'min:3'
            ],
            'daikin_rep_phone_number' => [
                'required',
                'min:7',
                config('panel.valid_phone_number')
            ],
            'estimate_date'           => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'repair_team_id' => [
                'required',
                'integer',
                // 'exists:servicing_teams,id'
            ],
        ];
    }
}
