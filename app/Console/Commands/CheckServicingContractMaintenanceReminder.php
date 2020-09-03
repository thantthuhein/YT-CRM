<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\ServicingSetup;
use Illuminate\Console\Command;

class CheckServicingContractMaintenanceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:contract-maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check maintenance for servicing contract';

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
        $month = (int) config('reminder.servicing.contract_maintenance.month');
        $type = config('reminder.servicing.contract_maintenance.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $monthAfter = Carbon::now()->addMonths($month)->format('Y-m-d');

        $servicingSetUps = ServicingSetup::where('request_type', config('servicingSetup.request_type_contract'))
                                            ->whereNull('status')
                                            ->where('estimated_date', $monthAfter)
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
            $remainingJob->inCharges()->attach($servicingSetUp->morphable->inhouse_installation->site_engineer_id);
        }
    }
}
