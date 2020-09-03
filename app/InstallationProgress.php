<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallationProgress extends Model
{
    use SoftDeletes;

    public $table = 'installation_progresses';

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
        'latest_updated_by_id',
        'inhouse_installation_id',
    ];

    public function inhouse_installation()
    {
        return $this->belongsTo(InHouseInstallation::class, 'inhouse_installation_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function latest_updated_by()
    {
        return $this->belongsTo(User::class, 'latest_updated_by_id');
    }

    public static function maxProgress($inhouse_installation_id){
        $maxProgress = InstallationProgress::where('inhouse_installation_id', $inhouse_installation_id)->max('progress');
        return $maxProgress ?? '0';
    }

    public function lastProgress($inhouse_installation_id){
        $lastProgress = InstallationProgress::where('inhouse_installation_id', $inhouse_installation_id)->get()->last();
        return $lastProgress ? $lastProgress->progress : '0';
    }
}
