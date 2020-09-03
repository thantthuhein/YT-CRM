<?php

namespace App\Http\Requests;

use App\WarrantyClaimValidation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWarrantyClaimValidationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('warranty_claim_validation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:warranty_claim_validations,id',
        ];
    }
}
