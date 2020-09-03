<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicingComplementary extends Model
{
    use SoftDeletes;

    public $table = 'servicing_complementaries';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'first_maintenance_date',
        'second_maintenance_date',
    ];

    protected $fillable = [
        'created_at',
        'project_id',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'first_maintenance_date',
        'second_maintenance_date',
        'inhouse_installation_id',
    ];

    public function inhouse_installation()
    {
        return $this->belongsTo(InHouseInstallation::class, 'inhouse_installation_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getFirstMaintenanceDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setFirstMaintenanceDateAttribute($value)
    {
        $this->attributes['first_maintenance_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getSecondMaintenanceDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setSecondMaintenanceDateAttribute($value)
    {
        $this->attributes['second_maintenance_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
        // $this->inhouse_installation->tc_time->addMonths(12);
    }

    public function servicing_setups()
    {
        return $this->morphMany('App\ServicingSetup', 'morphable');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }
}
