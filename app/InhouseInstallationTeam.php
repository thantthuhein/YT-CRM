<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InhouseInstallationTeam extends Model
{
    use SoftDeletes;

    public $table = 'inhouse_installation_teams';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'servicing_team_id',
        'inhouse_installation_id',
    ];

    public function servicing_team()
    {
        return $this->belongsTo(ServicingTeam::class, 'servicing_team_id');
    }

    public function inhouse_installation()
    {
        return $this->belongsTo(InHouseInstallation::class, 'inhouse_installation_id');
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
