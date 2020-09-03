<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\SaleContract;
use Illuminate\Console\Command;

class SaleContractEstimatedDateCheckReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:salecontract-estimated-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if estimated date include or not after Sale Contract has been created.';

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
        $days = (int)config('reminder.sale_contract.estimated_date.day');
        $type = config('reminder.sale_contract.estimated_date.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $threeDaysBefore = Carbon::now()->subDays($days);

        $saleContracts = SaleContract::where('has_installation', true)
                                        ->where('created_at', "<=", $threeDaysBefore)
                                        ->doesntHave('inHouseInstallation')
                                        ->cursor();

        foreach($saleContracts as $saleContract){
            $remainingJob = RemainingJob::create([
                'reminder_type_id' => $reminderType->id,
            ]);

            $remainingJob->attachMorph($saleContract);
            /**
             * attach in charge user
             *
             */
            $saleEngineerId = $saleContract->sale_engineer->id ?? $saleContract->created_by->id;
            $remainingJob->inCharges()->attach($saleEngineerId);
        }
    }
}
