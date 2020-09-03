<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class HandOverPdf extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'hand_over_pdfs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'file_type',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'inhouse_installation_id',
        'url'
    ];

    const FILE_TYPE_SELECT = [
        'bq'                    => 'BQ',
        'as-built'              => 'As-built',
        'test-report'           => 'Test Report',
        'operation-maintenance' => 'Operation And Maintenance',
        'warranty-certificate'  => 'Warranty Certificate',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function inhouse_installation()
    {
        return $this->belongsTo(InHouseInstallation::class, 'inhouse_installation_id');
    }

    public function scopeUploadedFile($query, $type)
    {   
        return $query->where('file_type', $type);
    }

    public function getTypeAttribute()
    {
        if ($this->file_type == 'equp_list') {
            return 'BQ - Equipment Lists';
        } else if ($this->file_type == 'warran_cert') {
            return 'Warranty Certificate';
        } else if ($this->file_type == 'as_build') {
            return 'As-built';
        } else if ($this->file_type == 'test_report') {
            return 'Test Report';
        } else if ($this->file_type == 'operation_mainteneance') {
            return 'Operation And Maintenance';
        } else {
            return 'Unknown';
        }
    }

    // public function getUrlAttribute()
    // {
    //     return $this->getMedia('url')->last();
    // }
}
