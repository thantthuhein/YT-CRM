<?php

namespace App\Console\Commands;

use App\InHouseInstallation;
use App\InstallationProgress;
use App\Quotation;
use Carbon\Carbon;
use App\ReminderType;
use App\SaleContract;
use Illuminate\Console\Command;
use App\RemainingJob;

class InstallationProgressWeeklyUpdateCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:installation-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check weekly update for installation progress';

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
        $days = (int)config('reminder.sale_contract.installation_progress.day');
        $type = config('reminder.sale_contract.installation_progress.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $weekBefore = Carbon::now()->subDays($days);

        $inhouseInstallations = InHouseInstallation::where('status', "!=",config('status.installation_status.complete'))
                                                    ->where(function($mainQuery)use($weekBefore){
                                                        $mainQuery->whereHas('installationProgresses', function($query) use($weekBefore){
                                                                        $query->where('created_at', "<=", $weekBefore);
                                                                    })
                                                                    ->orWhere(function($subQuery) use($weekBefore){
                                                                        $subQuery->doesntHave('installationProgresses')
                                                                                    ->where('created_at', "<=", $weekBefore);
                                                                    });
                                                    })
                                                    ->cursor();
        foreach($inhouseInstallations as $inhouseInstallation){
            $remainingJob = RemainingJob::create([
                'reminder_type_id' => $reminderType->id,
            ]);

            $remainingJob->attachMorph($inhouseInstallation);

            /**
             * attach in charge user
             *
             */
            $remainingJob->inCharges()->attach($inhouseInstallation->site_engineer_id);
        }
    }
}
