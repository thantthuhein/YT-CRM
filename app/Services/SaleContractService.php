<?php

namespace App\Services;

use App\SaleContract;
use App\PaymentStep;
use App\SaleContractPdf;
use App\EquipmentDeliverySchedule;

use App\Traits\ImageUploadTrait;

class SaleContractService {

    use ImageUploadTrait;

    public static function storeSaleContract($morph, $request){        
        $userId = \Auth::user()->id;
        
        $datas = $request->all();                  
        
        $saleContract = SaleContract::create($request->except(['text', 'file', 'installation_type']));

        $saleContract->created_by_id = $userId;
        $saleContract->save();

        /**
         * Attach morph relation
         */
        $saleContract->attachMorph($morph);

        $totalPaymentSteps = config("paymentSteps");
        
        for($i = 1; $i <= $saleContract->payment_terms;$i++) {

            $paymentStep = new PaymentStep();
            $paymentStep->title = $totalPaymentSteps[$i];
            $paymentStep->sale_contract_id = $saleContract->id;
            $paymentStep->save();

        }

        if ($request->has('text') && $request->has('file')) {
            $pdfs = $datas['file'];
            $titles = $datas['text'];        

            foreach($titles as $key => $title){
                if(array_key_exists($key, $pdfs)){
    
                    $pdf = $pdfs[$key];
                    /**
                     * Save sale contract pdfs
                     */
                    $folder = config('bucket.sale_contract');
                    $url = static::storeFileToBucket($title, $pdf, $folder);
    
                    /**
                     * Store pdf in database
                     */
                    // $iteration = 1;
    
                    SaleContractPdf::create([
                        'title' => $title,
                        'url' => $url,
                        'sale_contract_id' => $saleContract->id,
                        'uploaded_by_id' => $userId
                    ]);
    
                }
            }   
        }
        
        if ($request->has('description') && $request->has('delivered_at')) {
            $pdfs = $datas['file'];    
    
            /**
             * Equipment Delivery Schedule
             */
            foreach($datas['description'] as $key => $description){
                if($deliveredAt = $datas['delivered_at'][$key]){
                    EquipmentDeliverySchedule::create([
                        'sale_contract_id' => $saleContract->id,
                        'description' => $description,
                        'delivered_at' => $deliveredAt,
                        'created_by_id' => $userId
                    ]);
                }
            }
        }
        
        if( (bool)$request->has_installation ){
            /**
             * Store installation type
             */
            $saleContract->installation_type = $datas['installation_type'];
            $saleContract->save();

            // abort_if(Gate::denies('upload_other_docs_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            return redirect()->route("admin.sale-contracts.upload-other-documents", [$saleContract]);
        }
       
        return redirect()->route('admin.sale-contracts.index');
    }

}