<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class QuotationRevision extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'quotation_revisions';

    protected $appends = [
        'quotation_pdf',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'quoted_date',
    ];

    const STATUS_SELECT = [
        'pending'  => 'Pending',
        'possible' => 'Possible',
        'win'      => 'Win',
        'loss'     => 'Loss',
    ];

    protected $fillable = [
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'quoted_date',
        'quotation_id',
        'created_by_id',
        'updated_by_id',
        'quotation_revision',
        "quotation_pdf"
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'quotation_revision_id', 'id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function getQuotedDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setQuotedDateAttribute($value)
    {
        $this->attributes['quoted_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getQuotationPdfAttribute()
    {
        return $this->attributes['quotation_pdf'];
    }

    public function suggestQuotationRevisionNumber()
    {
        if ( $this->quotation_revision == NULL ) {
            return 'R';

        } elseif ( $this->quotation_revision == 'R' ) {
            return 'R1';
            
        } elseif ( strlen($this->quotation_revision) > 2 ) {
            return 'R';
        } else {
            $number = substr($this->quotation_revision,1);
            
            return 'R' . (int) ++$number;
        }
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
