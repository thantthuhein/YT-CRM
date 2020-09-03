<?php

namespace App\Services;

use App\Enquiry;
use App\Customer;
use App\Quotation;
use App\QuotationRevision;
use App\Traits\ImageUploadTrait;

class QuotationService {

    use ImageUploadTrait;
    
    public function createQuotation($request)
    {
        $quotation = new Quotation();
        
        $quotation->quotation_number_type = $request["quotation_number_type"];
        $quotation->quotation_number = $request["number"];
        $quotation->customer_id = $request["customer_id"];
        $quotation->enquiries_id = $request["enquiry_id"];
        $quotation->year = $request["year"];
        $quotation->number = $request["number"];
        $quotation->customer_address = $request["customer_address"];
        
        $quotation->status = $request["status"];

        $quotation->customer_id = $request["customer_id"];
        $quotation->enquiries_id = $request["enquiry_id"];
        
        $quotation->created_by_id = auth()->user()->id; 
        $quotation->updated_by_id = auth()->user()->id; 
        
        $quotation->save();        

        $customer = Customer::findOrFail($request["customer_id"]);
        $customer->update([
            'address' => $request["customer_address"]
        ]);
        
        $quotationRevision = new QuotationRevision();
        $quotationRevision->quotation_id = $quotation->id;
        $quotationRevision->status = $request["status"];
        $quotationRevision->quoted_date = $request["quoted_date"];
        $quotationRevision->quotation_revision = NULL;

        $quotationRevision->created_by_id = auth()->user()->id; 
        $quotationRevision->updated_by_id = auth()->user()->id; 

        if ( isset($request['quotation_pdf'])) {
            $title = $request['quoted_date'];
            $quotationRevision->quotation_pdf = static::storeFileToBucket($title, $request['quotation_pdf']);
        }

        $quotationRevision->save();

        $enquiry = Enquiry::findOrFail($request["enquiry_id"]);
        $enquiry->status = 'active';
        $enquiry->update();

        return $quotation;

    }
    
}
