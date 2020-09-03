<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarrantyClaimValidation extends Model
{
    use SoftDeletes;

    public $table = 'warranty_claim_validations';

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'actual_date',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'actual_date',
        'created_by_id',
        'updated_by_id',
        'repair_team_id',
    ];

    public function warrantyClaims()
    {
        return $this->hasMany(WarrantyClaim::class, 'warranty_claim_validation_id', 'id');
    }

    public function repair_team()
    {
        return $this->belongsTo(RepairTeam::class, 'repair_team_id');
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
}
