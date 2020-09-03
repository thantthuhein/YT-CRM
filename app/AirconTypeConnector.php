<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AirconTypeConnector extends Model
{
    use SoftDeletes;

    public $table = 'aircon_type_connectors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'updated_at',
        'created_at',
        'deleted_at',
        'enquiries_id',
    ];

    public function enquiries()
    {
        return $this->belongsTo(Enquiry::class, 'enquiries_id');
    }

    public function aircon_types()
    {
        return $this->belongsToMany(AirconType::class);
    }
}
