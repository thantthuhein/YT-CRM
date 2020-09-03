<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    use SoftDeletes;

    public $table = 'reminders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'remindable',
        'created_at',
        'updated_at',
        'deleted_at',
        'reminable_type',
    ];

    public function reminderTrashes()
    {
        return $this->hasMany(ReminderTrash::class, 'reminder_id', 'id');
    }
}
