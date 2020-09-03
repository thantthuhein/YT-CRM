<?php

namespace App\Http\Requests;

use App\MaterialDeliveryProgress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreMaterialDeliveryProgressRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('material_delivery_progress_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'progress' => "required|min:1|max:100|integer",
            'remark' => 'required|string',
            'delivered_at' => 'required',
            'material_pdf' => 'required|array',
            'material_pdf.*' => 'required|mimes:pdf|max:'.config('panel.pdf_max_size')
        ];
    }

    public function messages()
    {
        return [
            'material_pdf.*.required' => "Upload at least one pdf file.",
            'material_pdf.*.mimes' => "File type must be PDF."
        ];
    }
}
