<?php

namespace App\Http\Requests;

use App\InHouseInstallation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyInHouseInstallationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('in_house_installation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:in_house_installations,id',
        ];
    }
}
