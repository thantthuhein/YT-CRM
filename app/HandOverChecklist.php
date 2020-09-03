<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HandOverChecklist extends Model
{
    protected $dates = [
        'uploaded_at',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'uploaded_at',
        'type',
        'is_necessary',
        'in_house_installation_id'
    ];

    protected $casts = [
        'is_necessary' => "boolean"
    ];
}
