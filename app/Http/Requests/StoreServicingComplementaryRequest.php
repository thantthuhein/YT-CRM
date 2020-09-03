<?php

namespace App\Http\Requests;

use App\ServicingComplementary;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServicingComplementaryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_complementary_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            "project_id" => "nullable",
            "inhouse_installation_id" => "required",
            "request_type" => "required",
        ];
    }
}
