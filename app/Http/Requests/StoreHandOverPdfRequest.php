<?php

namespace App\Http\Requests;

use App\HandOverPdf;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreHandOverPdfRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('hand_over_pdf_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
