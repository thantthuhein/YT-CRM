<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarrantyClaimRemark extends Model
{
    use SoftDeletes;

    public $table = 'warranty_claim_action_remarks';

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
        'warranty_claim_action_id',
        'created_by_id',
        'updated_by_id'
    ];

    public function warranty_claim_action()
    {
        return $this->belongsTo(WarrantyClaimAction::class, 'warranty_claim_action_id');
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
