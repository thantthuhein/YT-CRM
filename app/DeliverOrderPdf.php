<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverOrderPdf extends Model
{
    protected $fillable = [
        'url', 'warranty_claim_action_id'
    ];
    
    public function warranty_claim_action()
    {
        return $this->belongsTo('App\WarrantyClaimAction');
    }
}
