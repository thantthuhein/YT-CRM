<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\ReminderType;
use App\ServicingSetup;
use Illuminate\Console\Command;
use App\RemainingJob;

class CheckMaintenanceEstimatedDateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:maintenance-estimated-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check maintenance estimated date';

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
        $day = (int) config('reminder.servicing.maintenance_estimated_date.day');
        $type = config('reminder.servicing.maintenance_estimated_date.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $tomorrow = Carbon::now()->addDays($day)->format('Y-m-d');

        $servicingSetUps = ServicingSetup::whereNull('status')
                                            ->where('estimated_date', $tomorrow)
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
