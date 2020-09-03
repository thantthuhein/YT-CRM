<?php

namespace App\Services;

use App\Quotation;
use App\QuotationRevision;
use App\Traits\ImageUploadTrait;

class QuotationRevisionService {

    use ImageUploadTrait;

    public function createQuotationRevision($request)
    {
        $quotationRevision = new QuotationRevision();
        $quotationRevision->quotation_revision = $request['quotation_revision'];
        $quotationRevision->quotation_id = $request['quotation_id'];
        $quotationRevision->quoted_date = $request['quoted_date'];
        $quotationRevision->created_by_id = auth()->user()->id;
        $quotationRevision->updated_by_id = auth()->user()->id;
        $quotationRevision->status = $request['status'];

        // title name = quotation_id + quotation_revision
        $title = $request['quotation_id'] . $request['quotation_revision'];

        $quotationRevision->quotation_pdf = static::storeFileToBucket($title, $request['quotation_pdf']);
        
        $quotationRevision->save();
        
        $quotation = Quotation::findOrFail($quotationRevision->quotation->id);
        $quotation->status = $request['status'];
        $quotation->save();

    }

}