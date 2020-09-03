<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicingContract extends Model
{
    use SoftDeletes;

    public $table = 'servicing_contracts';

    const INTERVAL_RADIO = [
        '3'  => '3',
        '4'  => '4',
        '6'  => '6',
        '9'  => '9',
        '12' => '12',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'contract_end_date',
        'contract_start_date',
    ];

    protected $fillable = [
        'remark',
        'interval',
        'project_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'contract_end_date',
        'contract_start_date',
        'inhouse_installation_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function inhouse_installation()
    {
        return $this->belongsTo(InHouseInstallation::class, 'inhouse_installation_id');
    }

    public function getContractStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setContractStartDateAttribute($value)
    {
        $this->attributes['contract_start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getContractEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setContractEndDateAttribute($value)
    {
        $this->attributes['contract_end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
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
