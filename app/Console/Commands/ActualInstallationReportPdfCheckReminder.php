<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\InHouseInstallation;
use Illuminate\Console\Command;

class ActualInstallationReportPdfCheckReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:actual-installation-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check autual installation report has been uploaded by Service Manager';

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
        $days = (int) config('reminder.sale_contract.actual_installation_report.day');
        $type = config('reminder.sale_contract.actual_installation_report.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $weekBefore = Carbon::now()->subDays($days);

        $inHouseInstallations = InHouseInstallation::whereNull('actual_installation_report_pdf')
                                                    ->where('status', config('status.installation_status.complete'))
                                                    ->whereHas('installationProgresses', function($query)use($weekBefore){
                                                        $query->latest()->where('created_at', "<=", $weekBefore);
                                                    })
                                                    ->with('sale_contract')
                                                    ->cursor();
                                                    
        foreach($inHouseInstallations as $inHouseInstallation)
        {
            $remainingJob = RemainingJob::create([
                'reminder_type_id' => $reminderType->id,
            ]);

            $remainingJob->attachMorph($inHouseInstallation);

            /**
             * attach in charge user
             *
             */
            $remainingJob->inCharges()->attach($inHouseInstallation->site_engineer_id);
        }
    }
}
