<?php

namespace App\Http\Requests;

use App\SubCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateSubCompanyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sub_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'contact_person_phone_number' => 'required|min:7|' . config('panel.valid_phone_number'),
        ];
    }
}
