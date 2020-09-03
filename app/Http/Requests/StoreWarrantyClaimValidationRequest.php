<?php

namespace App\Http\Requests;

use App\WarrantyClaimValidation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreWarrantyClaimValidationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('warranty_claim_validation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'actual_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'repair_team_id' => [
                'nullable',
                'integer'
            ]
        ];
    }
}
