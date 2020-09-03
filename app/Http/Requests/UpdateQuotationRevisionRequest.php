<?php

namespace App\Http\Requests;

use App\QuotationRevision;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateQuotationRevisionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('quotation_revision_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required',
            'quotation_pdf' => 'required|mimes:pdf|max:' . config('panel.pdf_max_size'),
            'quoted_date'        => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
        ];
    }
}
