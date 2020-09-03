<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReminderType extends Model
{
    /**
     * TYPES array keys are also used in reminder.php config file
     */
    const TYPES = [
        'followup' => 'followup',
        'sale_contract_estimated_date' => 'Estimated Date for Sale Contract',
        'uploaded_by_sale_engineer' => 'Things Uploaded By Sale Engineer',
        'installation_weekly_update' => 'Installation Weekly Update',
        'installation_necessary_docs' => 'Necessary Docs upload',
        'actual_installation_report_pdf' => 'Upload actual installation report pdf',
        'maintenance' => "Major/Minor Maintenance",
        'contract_maintenance' => "Servicing Contract Maintenance",
        'maintenance_estimated_date' => "Maintenance Estimated Date",
        'service_report' => "To Upload Service Upload PDF",
        'warranty_claim_form' => "To upload warranty claim pdf",
        'warranty_estimated_date' => "Reminder Before estimated date",
        'warranty_action_pdfs' => "To upload warranty claim action pdfs",
        'repair_estimated_date' => "Reminder before repair estimated date ",
        'repair_service_report' => "Remind to upload service report pdf",
        'warranty_claim_approve' => "Warranty Claim",
    ];

    protected $fillable = [
        'type',
        'description',
        'reminder_model',
        "action"
    ];

    public function whoToRemind()
    {
        return $this->belongsToMany(Role::class, "who_to_reminds", 'reminder_type_id', "role_id");
    }

    public function getRoleIdsAttribute()
    {
        return $this->whoToRemind ? $this->whoToRemind->pluck('id')->toArray() : [];
    }

    public function remainingJobs()
    {
        return $this->hasMany(RemainingJob::class, 'reminder_type_id', 'id');
    }
    
}
