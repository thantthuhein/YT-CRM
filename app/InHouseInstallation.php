<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class InHouseInstallation extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'in_house_installations';

    // protected $appends = [
    //     'actual_installation_report_pdf',
    // ];

    const STATUS_SELECT = [
        'pending'  => 'Pending',
        'ongoing'  => 'Ongoing',
        'complete' => 'Complete',
        'approve'  => 'Approved',
    ];

    protected $dates = [
        'tc_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'hand_over_date',
        'actual_end_date',
        'estimate_end_date',
        'actual_start_date',
        'estimate_start_date',
        'service_manager_approve_date',
        'project_manager_approve_date',
    ];

    protected $fillable = [
        'status',
        'tc_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'hand_over_date',
        'actual_end_date',
        'site_engineer_id',
        'sale_contract_id',
        'estimate_end_date',
        'actual_start_date',
        'estimate_start_date',
        'approved_service_manager_id',
        'approved_project_manager_id',
        'service_manager_approve_date',
        'project_manager_approve_date',
        'actual_installation_report_pdf'
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function installationProgresses()
    {
        return $this->hasMany(InstallationProgress::class, 'inhouse_installation_id', 'id');
    }

    public function materialDeliveryProgresses()
    {
        return $this->hasMany(MaterialDeliveryProgress::class, 'inhouse_installation_id', 'id');
    }

    public function handOverPdfs()
    {
        return $this->hasMany(HandOverPdf::class, 'inhouse_installation_id', 'id');
    }

    public function handOverChecklists(){
        return $this->hasMany(HandOverChecklist::class);
    }

    public function inhouseInstallationTeams()
    {
        return $this->hasMany(InhouseInstallationTeam::class, 'inhouse_installation_id', 'id');
    }

    public function servicingComplementaries()
    {
        return $this->hasMany(ServicingComplementary::class, 'inhouse_installation_id', 'id');
    }

    public function servicingContracts()
    {
        return $this->hasMany(ServicingContract::class, 'inhouse_installation_id', 'id');
    }

    public function site_engineer()
    {
        return $this->belongsTo(User::class, 'site_engineer_id');
    }

    public function sale_contract()
    {
        return $this->belongsTo(SaleContract::class, 'sale_contract_id');
    }

    public function getEstimateStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEstimateStartDateAttribute($value)
    {
        $this->attributes['estimate_start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEstimateEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEstimateEndDateAttribute($value)
    {
        $this->attributes['estimate_end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getActualStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setActualStartDateAttribute($value)
    {
        $this->attributes['actual_start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getActualEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setActualEndDateAttribute($value)
    {
        $this->attributes['actual_end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getTcTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format_2')) : null;
    }

    public function setTcTimeAttribute($value)
    {
        $this->attributes['tc_time'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getHandOverDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setHandOverDateAttribute($value)
    {
        $this->attributes['hand_over_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    // public function getActualInstallationReportPdfAttribute()
    // {
    //     return $this->getMedia('actual_installation_report_pdf')->last();
    // }

    public function getServiceManagerApproveDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setServiceManagerApproveDateAttribute($value)
    {
        $this->attributes['service_manager_approve_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function approved_service_manager()
    {
        return $this->belongsTo(User::class, 'approved_service_manager_id');
    }

    public function getProjectManagerApproveDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setProjectManagerApproveDateAttribute($value)
    {
        $this->attributes['project_manager_approve_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function approved_project_manager()
    {
        return $this->belongsTo(User::class, 'approved_project_manager_id');
    }

    public function isProjectApproved(){
        $isProjectApproved = false;
        
        if ( $this->approved_service_manager_id && $this->approved_project_manager_id ) {
            $isProjectApproved = true;
        }
        else {
            $isProjectApproved = false;
        }

       return $isProjectApproved;
    }


    public function checkAndUpdateStatus(){
        if($this->approved_service_manager_id && $this->approved_project_manager_id){
            $this->approved_at = Carbon::now();
            $this->status = config('status.installation_status.approved');
            $this->save();
        }
    }

    public function getProgressAttribute(){
        return $this->installationProgresses->count() > 0 ? $this->installationProgresses()->latest()->first()->progress : 0;
    }

    public function getTeamsAttribute(){
        return implode(", ", $this->inhouseInstallationTeams->pluck('servicing_team.leader_name')->all());
    }

    public function getServicingTeamsAttribute()
    {
        return $this->inhouseInstallationTeams->pluck('servicing_team')->all();
    }
}
