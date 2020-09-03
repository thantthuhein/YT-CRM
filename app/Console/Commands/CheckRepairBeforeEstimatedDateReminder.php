<?php

namespace App\Console\Commands;

use App\User;
use App\Repair;
use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use Illuminate\Console\Command;

class CheckRepairBeforeEstimatedDateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:repair-estimated-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check repair reminder before estimated date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $day = (int)config('reminder.repair.repair_estimated_date.day');
        $type = config('reminder.repair.repair_estimated_date.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $tomorrow = Carbon::now()->addDays($day)->format('Y-m-d');

        $repairs = Repair::whereNull('actual_date')
                            ->where('estimate_date', $tomorrow)
                            ->cursor();

        foreach ($repairs as $repair) {
            $remainingJob = RemainingJob::create([
                'reminder_type_id' => $reminderType->id,
            ]);

            $remainingJob->attachMorph($repair);
            /**
             * attach in charge user
             *
             */
            $userIds = User::whereHas('roles', function($query) {
                $query->where('title', 'Service Admin');
            })
            ->pluck('id');
            $remainingJob->inCharges()->attach($userIds);
        }
    }
}
