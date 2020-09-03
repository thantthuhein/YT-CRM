<?php

namespace App\Console\Commands;

use App\User;
use App\Repair;
use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use Illuminate\Console\Command;

class CheckRepairServiceReportPdfReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:repair-service-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check repair service report pdf';

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
        $day = (int)config('reminder.repair.repair_service_report.day');
        $type = config('reminder.repair.repair_service_report.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $threeDaysBefore = Carbon::now()->addDays($day)->format('Y-m-d');

        $repairs = Repair::whereNull('service_report_pdf')
                            ->where('actual_date', '<=', $threeDaysBefore)
                            ->cursor();
        foreach($repairs as $repair){
            $remainingJob = RemainingJob::create([
                'reminder_type_id' => $reminderType->id,
            ]);

            $remainingJob->attachMorph($repair);
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
