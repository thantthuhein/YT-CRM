<?php

namespace App\Console\Commands;

use App\Role;
use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\ServicingSetup;
use Illuminate\Console\Command;

class CheckFirstMaintenanceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check reminder for first maintenance';

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
        $month = (int) config('reminder.servicing.maintenance.month');
        $type = config('reminder.servicing.maintenance.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $monthAfter = Carbon::now()->addMonths($month)->format('Y-m-d');

        $servicingSetUps = ServicingSetup::where('request_type', config('servicingSetup.request_type_complementary'))
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
            // ! replace these ids with Service Admin Ids
            $userIds = Role::find(2)->users()->pluck('id');
            $remainingJob->inCharges()->attach($userIds);
        }
    }
}
