<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubComInstallation extends Model
{
    use SoftDeletes;

    public $table = 'sub_com_installations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'rating',
        'created_at',
        'updated_at',
        'deleted_at',
        'completed_year',
        'completed_month',
        'sale_contract_id',
        'installation_type',
    ];

    public function subCompanies()
    {
        return $this->belongsToMany(SubCompany::class, 'sub_com_connectors', 'sub_com_installation_id', 'sub_com_id');
    }

    public function subCompany(){
        return $this->subCompanies()->first();
    }

    public function sale_contract()
    {
        return $this->belongsTo(SaleContract::class, 'sale_contract_id');
    }
}
