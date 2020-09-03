<?php

namespace App\Http\Requests;

use App\RepairRemark;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRepairRemarkRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('repair_remark_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:repair_remarks,id',
        ];
    }
}
