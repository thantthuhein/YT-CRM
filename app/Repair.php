<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Repair extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'repairs';

    // protected $appends = [
    //     'service_report_pdf',
    // ];

    const HAS_SPARE_PART_REPLACEMENT_RADIO = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'actual_date',
        'estimate_date',
    ];

    const TEAM_TYPE_SELECT = [
        'inhouse' => 'In-house',
        'subcom'  => 'Sub-con',
        'Both'    => 'Both',
    ];
    protected $fillable = [
        'team_type',
        'oncall_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'actual_date',
        'estimate_date',
        'created_by_id',
        'updated_by_id',
        'has_spare_part_replacement',
        'service_report_pdf'
    ];

    // public function registerMediaConversions(Media $media = null)
    // {
    //     $this->addMediaConversion('thumb')->width(50)->height(50);
    // }

    public function repairTeamConnectors()
    {
        return $this->hasMany(RepairTeamConnector::class, 'repair_id', 'id');
    }

    public function repairRemarks()
    {
        return $this->hasMany(RepairRemark::class, 'repair_id', 'id');
    }

    public function oncall()
    {
        return $this->belongsTo(OnCall::class, 'oncall_id');
    }

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

    // public function getServiceReportPdfAttribute()
    // {
    //     return $this->getMedia('service_report_pdf')->last();
    // }    

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function getActiveStages()
    {
        $stages = ['edit-repair'];
        if($this->actual_date){
            array_push($stages, 'actual-action');
            array_push($stages, 'remark');
        }
        elseif($this->estimate_date){
            array_push($stages, 'actual-action');
        }
        return $stages;
    }

    public function getCurrentStage()
    {
        $stage = 'edit-repair';
        if($this->actual_date){
            $stage = 'remark';
        }
        elseif($this->estimate_date){
            $stage = "actual-action";
        }
        return $stage;
    }

    public function attachMorph($morphObj){
        $this->morphable_id = $morphObj->id;
        $this->morphable_type = get_class($morphObj);
        $this->save();
    }

    public function getStatusAttribute()
    {
        if ($this->oncall->status == 'pending' || $this->oncall->status == 'ongoing') {
            return config('status.repair.pending');
        } else {
            return config('status.repair.complete');
        }
    }

    public function getTypeAttribute()
    {        
        if ( $this->team_type == 'inhouse') {
            return 'In-house';
        } else if ( $this->team_type == 'subcom') {
            return 'Sub-con';
        } else {
            return $this->team_type;
        }
    }

}