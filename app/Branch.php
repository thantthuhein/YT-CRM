<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    public $table = 'branches';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'location',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function userBranchConnectors()
    {
        return $this->hasMany(UserBranchConnector::class, 'user_id', 'id');
    }
}
