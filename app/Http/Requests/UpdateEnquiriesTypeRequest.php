<?php

namespace App\Http\Requests;

use App\EnquiriesType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateEnquiriesTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('enquiries_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
            ],
        ];
    }
}
