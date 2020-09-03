<?php

namespace App;

use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $indexConfigurator = CompanyIndexConfigurator::class;
    public $table = 'companies';

    protected $searchRules = [
        CompanySearchRule::class
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $mapping = [
        'properties' => [
            'name' => [],
        ]
    ];

    protected $fillable = [
        'name',
        'email',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['name'] = $this->name;
        return $array;
    }
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class, 'company_id', 'id');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
}
