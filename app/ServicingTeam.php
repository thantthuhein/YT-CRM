<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicingTeam extends Model
{
    use SoftDeletes;

    public $table = 'servicing_teams';

    const IS_ACTIVE_RADIO = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function inhouseInstallationTeams()
    {
        return $this->hasMany(InhouseInstallationTeam::class, 'servicing_team_id', 'id');
    }

    public function warrantyactionTeamConnectors()
    {
        return $this->hasMany(WarrantyactionTeamConnector::class, 'servicing_team_id', 'id');
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
