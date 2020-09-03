<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairTeamConnector extends Model
{
    use SoftDeletes;

    public $table = 'repair_team_connectors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'repair_id',
        'morphable',
        'created_at',
        'updated_at',
        'deleted_at',
        'morphable_type',
    ];

    public function repair()
    {
        return $this->belongsTo(Repair::class, 'repair_id');
    }

    public function attachMorph($morphObj){
        $this->morphable = $morphObj->id;
        $this->morphable_type = get_class($morphObj);
        $this->save();
    }

    public function getAssignedTeamAttribute()
    {
        if ($this->morphable_type == 'App\RepairTeam') {
            return RepairTeam::findOrFail($this->morphable);
        } else if ($this->morphable_type == 'App\SubCompany') {
            return SubCompany::findOrFail($this->morphable);
        }
    }
}
