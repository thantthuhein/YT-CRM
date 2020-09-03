<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadOtherDocumentSaleContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'iteration' => [
            //     'required',
            //     'integer',
            //     'min:1'
            // ],
            'pdfs' => [
                'required',
                'array'
            ],
            'pdf.*' => [
                'required',
                'mimes:pdf'
            ],
        ];
    }

    public function messages()
    {
        return [
            "pdfs.*.mimes" => "Invalid file format(only pdf files are allowed).",
            "pdfs.*" => "Some of the pdf file is missing.",
        ];
    }
}
