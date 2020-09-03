<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class WarrantyClaim extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'warranty_claims';

    // protected $appends = [
    //     'warranty_claim_pdf',
    // ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'submitted' => 'Submitted',
        'pending'   => 'Pending',
        'accepted'  => 'Accepted',
        'rejected'  => 'Rejected',
    ];

    protected $fillable = [
        'remark',
        'status',
        'oncall_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'warranty_claim_action_id',
        'warranty_claim_validation_id',
        'warranty_claim_pdf',
        'approved_at',
    ];

    // public function registerMediaConversions(Media $media = null)
    // {
    //     $this->addMediaConversion('thumb')->width(50)->height(50);
    // }

    // public function warrantyClaimRemarks()
    // {
    //     return $this->hasMany(WarrantyClaimRemark::class, 'warranty_claim_id', 'id');
    // }

    public function oncall()
    {
        return $this->belongsTo(OnCall::class, 'oncall_id');
    }

    public function warranty_claim_validation()
    {
        return $this->belongsTo(WarrantyClaimValidation::class, 'warranty_claim_validation_id');
    }

    public function warranty_claim_action()
    {
        return $this->belongsTo(WarrantyClaimAction::class, 'warranty_claim_action_id');
    }

    // public function getWarrantyClaimPdfAttribute()
    // {
    //     return $this->getMedia('warranty_claim_pdf')->last();
    // }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function getCurrentStages()
    {
        if($this->status == "accepted" || $this->status == "rejected")
        {
            $currentStage = ['status', 'pdf_upload', 'claim_validation', 'claim_action'];
        }
        elseif($this->status == 'pending')
        {
            $currentStage = ['status', 'pdf_upload', 'claim_validation'];
        }
        else{
            $currentStage = ['status', 'pdf_upload'];
        }
        return $currentStage;
    }

    public function getCurrentStage()
    {
        if($this->status == "submitted")
        {
            $currentStage = 'pdf_upload';
        }
        elseif($this->status == "pending")
        {
            $currentStage = 'claim_validation';
        }
        else{
            $currentStage = 'claim_action';
        }

        return $currentStage;
    }

    public function showAcceptReject()
    {
        $show = false;
        if($this->warranty_claim_validation && $this->warranty_claim_validation->actual_date && $this->warranty_claim_validation->repair_team_id )
        {
            $show = true;
        }
        return $show;
    }
}
