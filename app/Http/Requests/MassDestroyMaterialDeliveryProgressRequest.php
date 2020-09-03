<?php

namespace App\Http\Requests;

use App\MaterialDeliveryProgress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMaterialDeliveryProgressRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('material_delivery_progress_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:material_delivery_progresses,id',
        ];
    }
}
