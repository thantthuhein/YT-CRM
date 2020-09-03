<?php

namespace App\Http\Requests;

use App\MaterialDeliveryProgress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateMaterialDeliveryProgressRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('material_delivery_progress_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'progress' => "required|min:1|max:100|integer",
            'remark' => 'required|string',
            'delivered_at' => 'required|date_format:'. config('panel.date_format'),
            'material_pdf' => 'nullable|array',
            'material_pdf.*' => 'nullable|mimes:pdf|max:'.config('panel.pdf_max_size')
        ];
    }
}
