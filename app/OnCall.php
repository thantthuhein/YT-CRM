<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnCall extends Model
{
    use SoftDeletes;

    public $table = 'on_calls';

    const IS_NEW_CUSTOMER_RADIO = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'tentative_date'
    ];

    protected $fillable = [
        'remark',
        'project_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'customer_id',
        'created_by_id',
        'updated_by_id',
        'service_type_id',
        'is_new_customer',
        'sale_contract_id',
        'tentative_date'
    ];

    public function sale_contract()
    {
        return $this->hasOne(SaleContract::class, 'id', 'sale_contract_id');
    }

    public function warrantyClaims()
    {
        return $this->hasMany(WarrantyClaim::class, 'oncall_id', 'id');
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class, 'oncall_id', 'id');
    }

    public function servicingSetups()
    {
        return $this->hasMany(ServicingSetup::class, 'oncall_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function service_type()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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
