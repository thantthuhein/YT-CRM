<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReminderTrash extends Model
{
    use SoftDeletes;

    public $table = 'reminder_trashes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'updated_at',
        'created_at',
        'deleted_at',
        'reminder_id',
    ];

    public function reminder()
    {
        return $this->belongsTo(Reminder::class, 'reminder_id');
    }
}
