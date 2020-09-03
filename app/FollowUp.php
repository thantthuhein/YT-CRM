<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowUp extends Model
{
    use SoftDeletes;

    public $table = 'follow_ups';

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'follow_up_time',
    ];

    const STATUS_RADIO = [
        'pending'  => 'Pending',
        'possible' => 'Possible',
        'win'      => 'Win',
        'loss'     => 'Loss',
    ];

    protected $fillable = [
        'status',
        'remark',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'follow_up_time',
        'contact_person',
        'contact_number',
        'quotation_revision_id',
    ];

    public function quotation_revision()
    {
        return $this->belongsTo(QuotationRevision::class, 'quotation_revision_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFollowUpTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setFollowUpTimeAttribute($value)
    {
        $this->attributes['follow_up_time'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
