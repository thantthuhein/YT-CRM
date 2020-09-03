<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialDeliveryPdfs extends Model
{
    protected $fillable = [
        'material_delivery_progress_id',
        'pdf'
    ];
}
