<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    public $table = 'invoices';

    protected $fillable = [
        'title', 
        'description', 
        'iteration', 
        'invoice_pdf',
        'created_by_id', 
        'updated_by_id', 
        'payment_step_id'
    ];

    public function paymentStep()
    {
        return $this->belongsTo(App\PaymentStep::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d. M. Y');
    }
}
