<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model
{
    protected $fillable = [
        'notes', 'customer_id', 'created_by_id', 'updated_by_id', 
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo('App\User', 'updated_by_id');
    }
}
