<?php

namespace App\Http\Requests;

use App\ServicingSetupRemark;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServicingSetupRemarkRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_setup_remark_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
