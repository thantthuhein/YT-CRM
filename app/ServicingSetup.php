<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class ServicingSetup extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'servicing_setups';

    protected $appends = [
        
    ];

    const IS_MAJOR_RADIO = [
        '1' => 'Major',
        '0' => 'Minor',
    ];

    const STATUS = [
        'pending' => 'Pending',
        'complete' => 'Complete',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'actual_date',
        'estimated_date',
    ];

    const TEAM_TYPE_SELECT = [
        'inhouse' => 'Inhouse',
        'subcom'  => 'Sub Company',
        'both'    => 'Both',
    ];

    protected $fillable = [
        'project_id',
        'is_major',
        'is_started',
        'estimated_date',
        'actual_date',
        'request_type',
        'team_type',
        'status',
        'service_report_pdf',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'oncall_id',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function servicingTeamConnectors()
    {
        return $this->hasMany(ServicingTeamConnector::class, 'servicing_setup_id', 'id');
    }

    public function servicingSetupRemarks()
    {
        return $this->hasMany(ServicingSetupRemark::class, 'servicing_setup_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function oncall()
    {
        return $this->belongsTo(OnCall::class, 'oncall_id');
    }

    public function getEstimatedDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEstimatedDateAttribute($value)
    {
        $this->attributes['estimated_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getActualDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setActualDateAttribute($value)
    {
        $this->attributes['actual_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getRequestTypeAttribute($value)
    {
        return ucfirst($value);
    }

    public function morphable()
    {
        return $this->morphTo();
    }

    public function attachMorph($morphObj){
        $this->morphable_id = $morphObj->id;
        $this->morphable_type = get_class($morphObj);
        $this->save();
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
        $stages = ['edit-servicing-setup'];
        if($this->actual_date){
            array_push($stages, 'actual-action');
            array_push($stages, 'remark');
        }
        elseif($this->estimated_date){
            array_push($stages, 'actual-action');
        }
        return $stages;
    }

    public function getCurrentStage()
    {
        $stage = 'edit-servicing-setup';
        if($this->actual_date){
            $stage = 'remark';
        }
        elseif(! $this->servicingTeamConnectors->isEmpty()){
            $stage = "actual-action";
        }
        return $stage;
    }
}
