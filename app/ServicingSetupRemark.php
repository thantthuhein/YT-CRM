<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicingSetupRemark extends Model
{
    use SoftDeletes;

    public $table = 'servicing_setup_remarks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'remark',
        'created_at',
        'updated_at',
        'deleted_at',
        'servicing_setup_id',
        'created_by_id',
        'updated_by_id',
    ];

    public function servicing_setup()
    {
        return $this->belongsTo(ServicingSetup::class, 'servicing_setup_id');
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
