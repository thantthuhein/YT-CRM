<?php

namespace App\Http\Requests;

use App\WarrantyClaim;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreWarrantyClaimRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('warranty_claim_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
