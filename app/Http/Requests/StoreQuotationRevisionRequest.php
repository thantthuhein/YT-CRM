<?php

namespace App\Http\Requests;

use Gate;
use App\QuotationRevision;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;


class StoreQuotationRevisionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('quotation_revision_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'quotation_revision' => [
                'required',
                Rule::unique('quotation_revisions')->where(function($query) {
                    $query->where('quotation_id', $this->quotation_id);
                }) 
            ],
            // 'quotation_id' => 'required',
            'quoted_date'        => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'status' => 'required',
            'quotation_pdf' => 'required|mimes:pdf|max:' . config('panel.pdf_max_size'),
        ];
    }
}
