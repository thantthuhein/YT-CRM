<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOfSale extends Model
{
    use SoftDeletes;

    public $table = 'type_of_sales';

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
        return $this->hasMany(Enquiry::class, 'type_of_sales_id', 'id');
    }
}
