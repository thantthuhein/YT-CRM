<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemainingJob extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'reminder_type_id',
        'morph_id',
        'morph_type',
        'status',
        'completed_at',
        'completed_by_id',
        'deleted_at'
    ];

    public function reminderType()
    {
        return $this->hasOne(ReminderType::class, 'id', 'reminder_type_id');
    }

    public function inCharges()
    {
        return $this->belongsToMany(User::class, 'in_charges', 'remaining_job_id', 'user_id');
    }

    public function jobMorphs()
    {
        return $this->hasMany(JobMorph::class, 'remaining_job_id', 'id');
    }

    public function completedBy()
    {
        return $this->hasOne(User::class, 'id', 'completed_by_id');
    }

    public function scopeUnCompletedJobs($query)
    {
        return $query->where('completed_at', null);
    }

    public function scopeQuotationMorph($query, $quotationId){
        return $query->whereHas('jobMorphs', function($q) use ($quotationId) {

            $q->where('morph_id', $quotationId)->where('morph_type', 'App\Quotation');
                
        });
    }

    public function scopeSaleContractMorph($query, $saleContractId){
        return $query->whereHas('jobMorphs', function($q) use ($saleContractId) {

            $q->where('morph_id', $saleContractId)->where('morph_type', 'App\SaleContract');
                
        });
    }

    public function scopeFilterWithType($query, $type)
    {
        return $query->whereHas('reminderType', function($q) use ($type) {
            $q->where('type', $type);
        });
    }

    public function scopeInHouseInstallationMorph($query, $inhouseInstallationId){
        return $query->whereHas('jobMorphs', function($q)use($inhouseInstallationId){
            $q->where('morph_id', $inhouseInstallationId)
                ->where('morph_type', 'App\InHouseInstallation');
                
        });
    }

    public function scopeServicingSetupMorph($query, $servicingSetupId){
        return $query->whereHas('jobMorphs', function($q)use($servicingSetupId){
            $q->where('morph_id', $servicingSetupId)
                ->where('morph_type', 'App\ServicingSetup');
                
        });
    }

    public function scopeWarrantyClaimMorph($query, $warrantyClaimId){
        return $query->whereHas('jobMorphs', function($q)use($warrantyClaimId){
            $q->where('morph_id', $warrantyClaimId)
                ->where('morph_type', 'App\WarrantyClaim');
                
        });
    }

    public function scopeRepairMorph($query, $repairId){
        return $query->whereHas('jobMorphs', function($q)use($repairId){
            $q->where('morph_id', $repairId)
                ->where('morph_type', 'App\Repair');
                
        });
    }

    public function getQuotationMorphAttribute()
    {
        return $this->jobMorphs->filter(function($jobMorph){
            return $jobMorph->morph_type == 'App\Quotation';
        })->first();
    }

    public function getQuotationRevisionMorphAttribute()
    {
        return $this->jobMorphs->filter(function($jobMorph){
            return $jobMorph->morph_type == 'App\QuotationRevision';
        })->first();
    }

    public function getSaleContractMorphAttribute()
    {
        return $this->jobMorphs->filter(function($jobMorph){
            return $jobMorph->morph_type == 'App\SaleContract';
        })->first();
    }

    public function getInHouseInstallationMorphAttribute()
    {
        return $this->jobMorphs->filter(function($jobMorph){
            return $jobMorph->morph_type == 'App\InHouseInstallation';
        })->first();
    }

    public function getServicingSetupMorphAttribute()
    {
        return $this->jobMorphs->filter(function($jobMorph){
            return $jobMorph->morph_type == 'App\ServicingSetup';
        })->first();
    }

    public function getWarrantyClaimMorphAttribute()
    {
        return $this->jobMorphs->filter(function($jobMorph){
            return $jobMorph->morph_type == 'App\WarrantyClaim';
        })->first();
    }

    public function getRepairMorphAttribute()
    {
        return $this->jobMorphs->filter(function($jobMorph){
            return $jobMorph->morph_type == 'App\Repair';
        })->first();
    }

    public function attachMorph($morphObj)
    {
        $jobMorph = new JobMorph();
        $jobMorph->remaining_job_id = $this->id;
        $jobMorph->morph_id = $morphObj->id;
        $jobMorph->morph_type = get_class($morphObj);
        $jobMorph->save();
    }

    public function getReminderDescriptionAttribute()    
    {
        switch ($this->reminderType->type) {
            case 'followup':
                $quotationRevision = QuotationRevision::find($this->quotation_revision_morph->morph_id);
                if (! $quotationRevision) {
                    return '';
                }
                $quotationNumber = $quotationRevision->quotation->number ?? '';
                return $quotationNumber . ' was submitted last week and it is needed to follow up now';
            break;
            case 'sale_contract_estimated_date':
                $saleContract = SaleContract::find($this->sale_contract_morph->morph_id);
                $project = $saleContract->project ? $saleContract->project->name : '';
                return "The estimated start date and end date for " . $project . " haven’t filled up yet";
            break;
            case 'uploaded_by_sale_engineer':
                $saleContract = SaleContract::find($this->sale_contract_morph->morph_id);
                $project = $saleContract->project ? $saleContract->project->name : '';
                return "Other documents for Service Manager are not uploaded yet for the sales contract of " . $project;
            break;
            case 'installation_weekly_update':
                $inHouseInstallation = InHouseInstallation::find($this->in_house_installation_morph->morph_id);            
                if (! $inHouseInstallation) {
                    return "Weekly updates about installation progress haven't updated yet";
                }
                $project = optional(optional($inHouseInstallation)->sale_contract->project)->name ?? '';
                return "Weekly updates about installation progress for " . $project . " haven't updated yet";
            break;
            case 'installation_necessary_docs':
                $inHouseInstallation = InHouseInstallation::find($this->in_house_installation_morph->morph_id);
                if (! $inHouseInstallation) {
                    return "Handover files are not uploaded yet";
                }
                $project = optional(optional($inHouseInstallation)->sale_contract->project)->name ?? '';
                return "Handover files for ". $project ." are not uploaded yet";
            break;
            case 'actual_installation_report_pdf':
                $inHouseInstallation = InHouseInstallation::find($this->in_house_installation_morph->morph_id);                
                if (! $inHouseInstallation) {
                    return "Actual installation report is not uploaded yet";
                }
                $project = optional(optional($inHouseInstallation)->sale_contract->project)->name ?? '';
                return "Actual installation report for " . $project . " is not uploaded yet";
            break;
            case 'maintenance':
                $servicingSetup = ServicingSetup::find($this->servicing_setup_morph->morph_id);
                if (! $servicingSetup) {
                    return "Maintenance’s complimentary servicing will be next month";
                }
                $project = optional(optional($servicingSetup)->project)->name ?? '';
                return "Maintenance for " . $project . "’s complimentary servicing will be next month";
            breal;
            case 'contract_maintenance':
                $servicingSetup = ServicingSetup::find($this->servicing_setup_morph->morph_id);
                if (! $servicingSetup) {
                    return "Maintenance’s contract servicing will be next month";
                }
                $project = optional(optional($servicingSetup)->project)->name ?? '';
                return "Maintenance for " . $project . " ’s contract servicing will be next month";
            break;
            case 'maintenance_estimated_date':
                $servicingSetup = ServicingSetup::find($this->servicing_setup_morph->morph_id);
                if (! $servicingSetup) {
                    return "The estimated date for setting up maintenance will be tomorrow";
                }
                $project = optional(optional($servicingSetup)->project)->name ?? '';
                return "The estimated date for setting up " . $project . "’s maintenance will be tomorrow";
            break;
            case 'service_report':
                $servicingSetup = ServicingSetup::find($this->servicing_setup_morph->morph_id);
                if (! $servicingSetup) {
                    return "Service report PDF is not uploaded yet";
                }
                $project = optional(optional($servicingSetup)->project)->name ?? '';
                return "Service report PDF for " . $project . " is not uploaded yet";
            break;
            case 'warranty_claim_form':
                $warrantyClaim = WarrantyClaim::find($this->warranty_claim_morph->morph_id);
                if (! $warrantyClaim) {
                    return "Warranty claim form PDF is not uploaded yet";
                }
                $project = optional(optinal($warrantyClaim)->oncall->project)->name ?? '';
                return "Warranty claim form PDF for ". $project . " is not uploaded yet";
            break;
            case 'warranty_estimated_date':
                $warrantyClaim = WarrantyClaim::find($this->warranty_claim_morph->morph_id);
                if (! $warrantyClaim) {
                    return "Warranty claim for certain is accepted now";
                }
                $project = optional(optional($warrantyClaim)->oncall->project)->name ?? '';
                return "Warranty claim for " . $project . " is accepted now";
            break;
            case 'warranty_claim_approve':
                $warrantyClaim = WarrantyClaim::find($this->warranty_claim_morph->morph_id);
                if (! $warrantyClaim) {
                    return "The estimated date for warranty claim action will be tomorrow";
                }
                $project = optional(optional($warrantyClaim)->oncall->project)->name ?? '';
                return "The estimated date for " . $project . "’s warranty claim action will be tomorrow";
            break;
            case 'warranty_action_pdfs':
                $warrantyClaim = WarrantyClaim::find($this->warranty_claim_morph->morph_id);
                if (! $warrantyClaim) {
                    return "Service reports from Daikin, Ywar Taw and Delivery Order are not uploaded yet";
                }
                $project = optional(optional($warrantyClaim)->oncall->project)->name ?? '';
                return "Service reports from Daikin, Ywar Taw and Delivery Order for " . $project . " are not uploaded yet";
            break;
            case 'repair_estimated_date':
                $repair = Repair::find($this->repair_morph->morph_id);
                if (! $repair) {
                    return "The estimated date for repair action will be tomorrow";
                }
                $project = optional(optional($repair)->oncall->project)->name ?? '';
                return "The estimated date for " . $project . "’s repair action will be tomorrow";
            break;
            case 'repair_service_report':
                $repair = Repair::find($this->repair_morph->morph_id);
                if (! $repair) {
                    return "Service report pdf Repair is not uploaded yet";
                }
                $project = optional(optional($repair)->oncall->project)->name ?? '';
                return "Service report pdf for " . $project ." is not uploaded yet";
            break;
            
            default:
                'No Action';
            break;                
        }
    }
}
