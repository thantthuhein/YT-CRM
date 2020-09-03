<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnquiriesType extends Model
{
    use SoftDeletes;

    public $table = 'enquiries_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class, 'enquiries_type_id', 'id');
    }
}
