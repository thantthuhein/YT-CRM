<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\WarrantyClaim;
use Illuminate\Console\Command;

class CheckWarrantyClaimActionPdfsReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:warranty-action-pdfs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check required pdfs for claim actions already uploaded or not';

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
        $day = (int) config('reminder.warranty.warranty_action_pdfs.day');
        $type = config('reminder.warranty.warranty_action_pdfs.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $threeDaysBefore = Carbon::now()->subDays($day)->format('Y-m-d');
                        
        $warrantyClaims = WarrantyClaim::where('status', '!=', 'rejected')
                                        ->whereHas('warranty_claim_action', function($query) use ($threeDaysBefore){
                                           $query->where('actual_date', '<=', $threeDaysBefore)
                                                    ->whereDoesntHave('deliver_order_pdfs')
                                                    ->orwhereDoesntHave('service_report_pdfs_for_daikin')
                                                    ->orwhereDoesntHave('service_report_pdfs_for_ywartaw');
                                                    // ->where(function($subQuery){
                                                    //     $subQuery->whereNull('deliver_order_pdfs')
                                                    //             ->orWhereNull('service_report_pdfs_for_daikin')
                                                    //             ->orWhereNull('service_report_pdfs_for_ywartaw');
                                                    // });
                                        })
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
