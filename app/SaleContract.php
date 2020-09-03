<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleContract extends Model
{
    use SoftDeletes;

    public $table = 'sale_contracts';

    protected $appends = [
        'project'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const HAS_INSTALLATION_RADIO = [
        '1' => "YES",
        '0'  => 'No',
    ];

    const INSTALLATION_TYPE_SELECT = [
        'inhouse' => 'In-house',
        'subcom'  => 'Sub-con',
        'Both'    => 'Both',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'payment_terms',
        'created_by_id',
        'updated_by_id',
        'payment_status',
        'has_installation',
        'installation_type',
        'current_payment_step',
    ];

    protected $casts = [
        'has_installation' => "boolean"
    ];

    public function morphableEnquiryQuotation(){
        return $this->morphTo('morphableEnquiryQuotation', 'morphable_type', 'morphable', 'id');
    }

    public function on_calls()
    {
        return $this->hasMany('App\OnCall');
    }

    public function enquiry()
    {
        if($this->morphable_type == 'App\Enquiry'){
            return $this->morphableEnquiryQuotation();
        }
        else{
            return $this->morphableEnquiryQuotation()->enquiries();
        }
    }

    public function getCompanyAttribute()
    {
        if($this->morphable_type == 'App\Enquiry'){
            return $this->morphableEnquiryQuotation->company;
        }
        else{
            return $this->morphableEnquiryQuotation->enquiry()->company;
        }
    }

    public function getProjectAttribute()
    {
        if($this->morphable_type == 'App\Enquiry'){
            return $this->morphableEnquiryQuotation->project;
        }
        else{
            return $this->morphableEnquiryQuotation->enquiry()->project;
        }
    }

    public function getCustomerAttribute(){
        if($this->morphable_type == 'App\Enquiry'){
            return Enquiry::find($this->morphable)->customer;
        }
        else{
            return Quotation::find($this->morphable)->customer;
        }
    }

    public function getSaleEngineerAttribute(){
        if($this->morphable_type == 'App\Enquiry'){
            return $this->morphableEnquiryQuotation->user;
        }
        else{
            return $this->morphableEnquiryQuotation->enquiry()->user;
        }
    }

    public function getMorphableNameAttribute(){
        $morphType = explode( "\\", $this->morphable_type);
        return last($morphType);
    }

    public function getAirconTypesAttribute()
    {
        if($this->morphable_type == 'App\Enquiry'){
            return $this->morphableEnquiryQuotation->airconTypes;
        }
        else{
            return $this->morphableEnquiryQuotation->enquiry()->airconTypes;
        }
    }

    public function saleContractPdfs()
    {
        return $this->hasMany(SaleContractPdf::class, 'sale_contract_id', 'id');
    }

    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class, 'sale_contract_id', 'id');
    }

    public function paymentSteps()
    {
        return $this->hasMany('App\PaymentStep');
    }

    public function equipmentDeliverySchedules()
    {
        return $this->hasMany(EquipmentDeliverySchedule::class, 'sale_contract_id', 'id');
    }

    public function subComInstallations()
    {
        return $this->hasMany(SubComInstallation::class, 'sale_contract_id', 'id');
    }

    public function getPaymentStatusAttribute()
    {
        return $this->considerPaymentStatus();
    }

    public function considerPaymentStatus()
    {
        
        if ( count($this->paymentSteps) > 0 ) {

            $totalCompletedSteps = $this->paymentSteps->where('completed_at', NULL);

            if ( count($totalCompletedSteps) == 0 ) {
                return 'Completed';
            } else {
                return 'Pending';
            }
        } else {

            return 'Pending';
            
        }

    }

    public function getCurrentPaymentStepAttribute()
    {
        return $this->considerCurrentPaymentStep();
    }

    public function considerCurrentPaymentStep()
    {
        // whereNotNull and whereNull now working 
        $totalCompletedSteps = $this->paymentSteps->where('completed_at', !NULL);
        
        return count($totalCompletedSteps);
    }

    public function inHouseInstallation()
    {
        return $this->hasOne(InHouseInstallation::class, 'sale_contract_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function attachMorph($morphObj) {
        $this->morphable = $morphObj->id;
        $this->morphable_type = get_class($morphObj);
        $this->save();
    }

    public function projectCompleted() {
        return $this->inHouseInstallation->status == "complete";
    }

    public function nextIteration(){
        $iteration = $this->saleContractPdfs()->max('iteration');
        return ++$iteration;
    }

    public function checkPaymentTerms()
    {
        $this->load('paymentSteps.invoices');

        $steps = $this->paymentSteps->filter(function($paymentStep) {
            return ! $paymentStep->invoices->isEmpty();
        });

        if ($steps->isEmpty()) {
            return TRUE;
        } else   {
            return FALSE;
        }
    }
}
