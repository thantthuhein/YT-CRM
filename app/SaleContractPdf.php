<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class SaleContractPdf extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'sale_contract_pdfs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'iteration',
        'url',
        'created_at',
        'updated_at',
        'deleted_at',
        'uploaded_by_id',
        'sale_contract_id',
        'is_other_docs'
    ];

    protected $casts = [
        'is_other_docs' => 'boolean'
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function sale_contract()
    {
        return $this->belongsTo(SaleContract::class, 'sale_contract_id');
    }

    // public function getUrlAttribute()
    // {
    //     return $this->url;
    // }

    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'uploaded_by_id');
    }

    public function scopeOtherDocs($query){
        return $query->where('is_other_docs', true);
    }
}
