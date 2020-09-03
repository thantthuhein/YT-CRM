<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentStep extends Model
{
    use SoftDeletes;

    public $table = 'payment_steps';

    protected $dates = [
        'completed_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title', 'completed_at', 'completed_by_id', 'sale_contract_id'
    ];

    public function saleContract()
    {
        return $this->belongsTo('App\SaleContract', 'sale_contract_id');
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice', 'payment_step_id', 'id');
    }

    public function get_current_iteration($payment_step_id)
    {
        $current_iteration = Invoice::where('payment_step_id', $payment_step_id)->max('iteration');

        if ( $current_iteration === null) {
            $iteration = 1;
        } else {
            $iteration = ++$current_iteration;
        }
        
        return $iteration;

    }

    public function getCompletedAtAttribute($value)
    {
        if ($value == NULL) {
            return NULL;
        }
        return \Carbon\Carbon::parse($value)->format('D | M. d. Y');
    }

}
