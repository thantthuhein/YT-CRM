<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobMorph extends Model
{
    protected $fillable = [
        'remaining_job_id',
        'morph_id',
        'morph_type'
    ];
}
