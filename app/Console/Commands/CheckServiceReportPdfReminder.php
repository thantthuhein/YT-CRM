<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\ServicingSetup;
use Illuminate\Console\Command;

class CheckServiceReportPdfReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:service-report-pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check reminder for service report pdf';

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
        $day = (int) config('reminder.servicing.service_report.day');
        $type = config('reminder.servicing.service_report.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $threeDaysBefore = Carbon::now()->subDays($day)->format('Y-m-d');

        $servicingSetUps = ServicingSetup::whereNotNull('status')
                                            ->whereNull('service_report_pdf')
                                            ->where('actual_date', '<=', $threeDaysBefore)
                                            ->cursor();

        foreach($servicingSetUps as $servicingSetUp){
            $remainingJob = RemainingJob::create([
                'reminder_type_id' => $reminderType->id,
            ]);

            $remainingJob->attachMorph($servicingSetUp);
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
