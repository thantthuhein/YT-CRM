<?php

namespace App\Http\Requests;

use App\CustomerEmail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCustomerEmailRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('customer_email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
