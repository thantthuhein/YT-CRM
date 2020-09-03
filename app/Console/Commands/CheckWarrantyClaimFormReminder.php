<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\WarrantyClaim;
use Illuminate\Console\Command;

class CheckWarrantyClaimFormReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:warranty-claim-form';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Warranty Claim Form Reminder';

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
        $day = (int) config('reminder.warranty.warranty_claim_form.day');
        $type = config('reminder.warranty.warranty_claim_form.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $threeDaysBefore = Carbon::now()->subDays($day);

        $warrantyClaims = WarrantyClaim::where('created_at', '<=', $threeDaysBefore)
                                        ->whereNull('warranty_claim_pdf')
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
