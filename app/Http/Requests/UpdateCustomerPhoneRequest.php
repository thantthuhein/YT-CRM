<?php

namespace App\Http\Requests;

use App\CustomerPhone;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCustomerPhoneRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('customer_phone_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
