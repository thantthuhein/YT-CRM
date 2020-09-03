<?php

namespace App\Http\Requests;

use App\HandOverPdf;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHandOverPdfRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('hand_over_pdf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:hand_over_pdfs,id',
        ];
    }
}
