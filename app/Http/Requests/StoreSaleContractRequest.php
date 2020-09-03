<?php

namespace App\Http\Requests;

use App\SaleContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSaleContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sale_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'has_installation'     => [
                'required',
            ],
            'payment_terms'        => [
                'integer',
                'min:1',
                'max:8',
            ],
            'installation_type' => [
                'required_if:has_installation,1',
            ],

            'description' => 'sometimes|required|array',
            'description.*' => 'sometimes|required',
            'delivered_at'  => 'sometimes|required|array',
            'delivered_at.*' => "sometimes|required|date_format:Y-m-d",
            
            'text' => "sometimes|required|array",
            'text.*' => "sometimes|required",
            'file' => "sometimes|required|array",
            'file.*' => "sometimes|required|mimes:pdf",
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Description field is required',
            'description.*.required' => 'Description field is required',
            'description.*' => 'Description field is invalid',
            'delivered_at.required' => 'Description field is required',
            'delivered_at.*.required' => 'Description field is required',
            'delivered_at.*' => 'Description field is invalid',
            "text.required" => "Title required.",
            "file.required" => "Upload at least one pdf.",
            "file.*.mimes" => "Invalid file format(only pdf files are allowed).",
            "text.*" => "Some of the pdf's title is missing.",
            "file.*" => "Some of the pdf file is missing.",
            'installation_type.required_if' => ":Attribute Field is required",            
        ];
    }
}
