<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairTeam extends Model
{
    use SoftDeletes;

    public $table = 'repair_teams';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const IS_ACTIVE_RADIO = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    protected $fillable = [
        'man_power',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'leader_name',
        'phone_number',
        'created_by_id',
        'updated_by_id',
    ];

    public function repair()
    {
        return $this->belongsTo('App\Repair', 'repair_id');
    }

    public function warrantyClaimValidations()
    {
        return $this->hasMany(WarrantyClaimValidation::class, 'repair_team_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function warranty_claim_actions()
    {
        return $this->hasMany('App\WarrantyClaimAction');
    }
}
