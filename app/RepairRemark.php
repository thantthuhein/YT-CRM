<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairRemark extends Model
{
    use SoftDeletes;

    public $table = 'repair_remarks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'remark',
        'repair_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id'
    ];

    public function repair()
    {
        return $this->belongsTo(Repair::class, 'repair_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }
}
