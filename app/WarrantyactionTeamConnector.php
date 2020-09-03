<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarrantyactionTeamConnector extends Model
{
    use SoftDeletes;

    public $table = 'warrantyaction_team_connectors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'servicing_team_id',
        'warranty_action_id',
    ];

    public function warranty_action()
    {
        return $this->belongsTo(WarrantyClaimAction::class, 'warranty_action_id');
    }

    public function servicing_team()
    {
        return $this->belongsTo(ServicingTeam::class, 'servicing_team_id');
    }
}
