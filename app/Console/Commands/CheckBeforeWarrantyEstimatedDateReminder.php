<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\WarrantyClaim;
use Illuminate\Console\Command;

class CheckBeforeWarrantyEstimatedDateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:warranty-estimated-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check reminder for warranty estimated date';

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
        $day = (int) config('reminder.warranty.warranty_estimated_date.day');
        $type = config('reminder.warranty.warranty_estimated_date.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $tomorrow = Carbon::now()->addDays($day)->format('Y-m-d');

        $warrantyClaims = WarrantyClaim::whereHas('warranty_claim_action', function($query) use ($tomorrow){
                                           $query->where('estimate_date', $tomorrow)
                                                    ->whereNull('actual_date');
                                        })
                                        ->where('status', '!=', 'rejected')
                                        ->cursor();
        foreach($warrantyClaims as $warrantyClaim){
            $remainingJob = RemainingJob::create([
                'reminder_type_id' => $reminderType->id,
            ]);

            $remainingJob->attachMorph($warrantyClaim);
            /**
             * attach in charge user
             *
             */
            $userIds = User::whereHas('roles', function($query){
                            $query->where('title', 'Service Admin');
                        })
                        ->pluck('id');
            $remainingJob->inCharges()->attach($userIds);
        }
    }
}
