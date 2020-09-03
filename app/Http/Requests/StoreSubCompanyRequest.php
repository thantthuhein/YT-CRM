<?php

namespace App\Http\Requests;

use App\SubCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSubCompanyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sub_company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'company_name' => [
                'required',
                'string'
            ],
            'contact_person_name' => [
                'required',
                'string'
            ],
            'contact_person_phone_number' => 'required|min:7|' . config('panel.valid_phone_number'),
        ];
    }
}
