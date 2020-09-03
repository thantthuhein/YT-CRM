<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentDeliverySchedule extends Model
{
    use SoftDeletes;

    public $table = 'equipment_delivery_schedules';

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'delivered_at',
    ];

    protected $fillable = [
        'updated_at',
        'created_at',
        'deleted_at',
        'description',
        'delivered_at',
        'created_by_id',
        'updated_by_id',
        'sale_contract_id',
    ];

    public function sale_contract()
    {
        return $this->belongsTo(SaleContract::class, 'sale_contract_id');
    }

    // public function getDeliveredAtAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    public function setDeliveredAtAttribute($value)
    {
        $this->attributes['delivered_at'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
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
