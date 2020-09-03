<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialDeliveryProgress extends Model
{
    use SoftDeletes;

    public $table = 'material_delivery_progresses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'remark',
        'progress',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'last_updated_by_id',
        'inhouse_installation_id',
        'delivered_at'
    ];

    public function inhouse_installation()
    {
        return $this->belongsTo(InHouseInstallation::class, 'inhouse_installation_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function last_updated_by()
    {
        return $this->belongsTo(User::class, 'last_updated_by_id');
    }

    public function material_delivery_pdfs(){
        return $this->hasMany(MaterialDeliveryPdfs::class);
    }

    public function getMaxProgressAttribute(){
        $materialProgresses = MaterialDeliveryProgress::where('inhouse_installation_id', $this->inhouse_installation_id)->max('progress');
        return $materialProgresses ?? '0';
    }
}
