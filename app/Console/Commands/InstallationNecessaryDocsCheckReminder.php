<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\InHouseInstallation;
use Illuminate\Console\Command;

class InstallationNecessaryDocsCheckReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:installation-necessary-docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the necessary docs are already uploaded or not';

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
        $days = (int) config('reminder.sale_contract.necesssary_docs.day');
        $type = config('reminder.sale_contract.necesssary_docs.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $weekBefore = Carbon::now()->subDays($days);

        $inHouseInstallations = InHouseInstallation::whereNotNull('tc_time')
                                                    ->where('status', config('status.installation_status.complete'))
                                                    ->doesntHave('handOverPdfs')
                                                    ->whereHas('installationProgresses', function($query)use($weekBefore){
                                                    $query->latest()->where('created_at', "<=", $weekBefore);
                                                    })
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
