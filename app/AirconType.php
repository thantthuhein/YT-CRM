<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AirconType extends Model
{
    use SoftDeletes;

    public $table = 'aircon_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'parent',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function airconTypeConnectors()
    {
        return $this->belongsToMany(AirconTypeConnector::class);
    }
}
