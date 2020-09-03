<?php

namespace App;

use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   

class Customer extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $indexConfigurator = CustomerIndexConfigurator::class;

    public $table = 'customers';
    protected $searchRules = [
        CustomerSearchRule::class
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
        'email'
    ];
    protected $mapping = [
        'properties' => [
            'name' => [],
        ]
    ];
    public function toSearchableArray()
    {
        $array = $this->toArray();
        // $array['name'] = $this->name;
        return $array;
    }

    public function customerEmails()
    {
        return $this->hasMany(CustomerEmail::class, 'customer_id', 'id');
    }

    public function customerEmail(){
        return $this->customerEmails()->latest()->first();
    }

    public function customerPhones()
    {
        return $this->hasMany(CustomerPhone::class, 'customer_id', 'id');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class, 'customer_id', 'id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'customer_id', 'id');
    }

    public function onCalls()
    {
        return $this->hasMany(OnCall::class, 'customer_id', 'id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function notes()
    {
        return $this->hasMany('App\CustomerNote');
    }
}
