<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class WarrantyClaimAction extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'warranty_claim_actions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'actual_date',
        'estimate_date',
    ];

    // protected $appends = [
    //     'deliver_order_pdf',
    //     'service_report_pdf_daikin',
    //     'service_report_pdf_ywar_taw',
    // ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'actual_date',
        'estimate_date',
        'created_by_id',
        'updated_by_id',
        'daikin_rep_name',
        'daikin_rep_phone_number',
        'deliver_order_pdf',
        'service_report_pdf_daikin',
        'service_report_pdf_ywar_taw',
        'repair_team_id',
    ];

    // public function registerMediaConversions(Media $media = null)
    // {
    //     $this->addMediaConversion('thumb')->width(50)->height(50);
    // }

    public function warrantyClaim()
    {
        return $this->hasOne(WarrantyClaim::class, 'warranty_claim_action_id', 'id');
    }

    public function servicingTeams()
    {
        return $this->belongsToMany(ServicingTeam::class, 'warrantyaction_team_connectors', 'warranty_action_id', 'servicing_team_id');
    }

    public function repairTeam()
    {
        return $this->belongsTo('App\RepairTeam', 'repair_team_id');
    }

    public function remarks()
    {
        return $this->hasMany(WarrantyClaimRemark::class, 'warranty_claim_action_id', 'id');
    }

    // public function getServiceReportPdfYwarTawAttribute()
    // {
    //     return $this->getMedia('service_report_pdf_ywar_taw')->last();
    // }

    // public function getServiceReportPdfDaikinAttribute()
    // {
    //     return $this->getMedia('service_report_pdf_daikin')->last();
    // }

    // public function getDeliverOrderPdfAttribute()
    // {
    //     return $this->getMedia('deliver_order_pdf')->last();
    // }

    public function getEstimateDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEstimateDateAttribute($value)
    {
        $this->attributes['estimate_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getActualDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setActualDateAttribute($value)
    {
        $this->attributes['actual_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function service_report_pdfs_for_daikin()
    {
        return $this->hasMany('App\ServiceReportPdfDaikin', 'warranty_claim_action_id');
    }

    public function service_report_pdfs_for_ywartaw()
    {
        return $this->hasMany('App\ServiceReportPdfYwarTaw', 'warranty_claim_action_id');
    }

    public function deliver_order_pdfs()
    {
        return $this->hasMany('App\DeliverOrderPdf', 'warranty_claim_action_id');
    }
}
