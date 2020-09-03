<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ScoutElastic\Searchable;

class Project extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $indexConfigurator = ProjectIndexConfigurator::class;

    public $table = 'projects';
    protected $searchRules = [
        ProjectSearchRule::class
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $mapping = [
        'properties' => [
            'name' => []
        ]
    ];
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['name'] = $this->name;
        return $array;
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class, 'project_id', 'id');
    }

    public function onCalls()
    {
        return $this->hasMany(OnCall::class, 'project_id', 'id');
    }

    public function servicingSetups()
    {
        return $this->hasMany(ServicingSetup::class, 'project_id', 'id');
    }

    public function servicingComplementaries()
    {
        return $this->hasMany(ServicingComplementary::class, 'project_id', 'id');
    }

    public function servicingContracts()
    {
        return $this->hasMany(ServicingContract::class, 'project_id', 'id');
    }
}
