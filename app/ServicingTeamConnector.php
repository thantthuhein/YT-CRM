<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicingTeamConnector extends Model
{
    use SoftDeletes;

    public $table = 'servicing_team_connectors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'morphable',
        'created_at',
        'updated_at',
        'deleted_at',
        'morphable_type',
        'servicing_setup_id',
    ];

    public function servicing_setup()
    {
        return $this->belongsTo(ServicingSetup::class, 'servicing_setup_id');
    }

    public function attachMorph($morphObj){
        $this->morphable = $morphObj->id;
        $this->morphable_type = get_class($morphObj);
        $this->save();
    }

    public function getAssignedTeamAttribute()
    {
        if ($this->morphable_type == 'App\ServicingTeam') {
            return ServicingTeam::find($this->morphable);
        } else if ($this->morphable_type == 'App\SubCompany') {
            return SubCompany::find($this->morphable);
        }
    }
}
