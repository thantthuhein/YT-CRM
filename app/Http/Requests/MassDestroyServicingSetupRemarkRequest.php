<?php

namespace App\Http\Requests;

use App\ServicingSetupRemark;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServicingSetupRemarkRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicing_setup_remark_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:servicing_setup_remarks,id',
        ];
    }
}
