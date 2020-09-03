<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentHistory extends Model
{
    use SoftDeletes;

    public $table = 'payment_histories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'updated_at',
        'created_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'payment_step_to',
        'sale_contract_id',
        'payment_step_from',
    ];

    public function sale_contract()
    {
        return $this->belongsTo(SaleContract::class, 'sale_contract_id');
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
