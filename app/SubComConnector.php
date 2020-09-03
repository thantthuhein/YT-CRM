<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubComConnector extends Model
{
    use SoftDeletes;

    public $table = 'sub_com_connectors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'sub_com_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'sub_com_installation_id',
    ];

    public function sub_com()
    {
        return $this->belongsTo(SubCompany::class, 'sub_com_id');
    }

    public function sub_com_installation()
    {
        return $this->belongsTo(SubComInstallation::class, 'sub_com_installation_id');
    }
}
