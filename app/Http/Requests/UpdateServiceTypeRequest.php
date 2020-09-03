<?php

namespace App\Http\Requests;

use App\ServiceType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateServiceTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('service_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
