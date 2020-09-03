<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\RemainingJob;
use App\ReminderType;
use App\SaleContract;
use Illuminate\Console\Command;

class SaleContractUploadedBySaleEngineerCheckReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:salecontract-upload-other-docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Check docs are uploaded or not by sale engineer for Sale Contract with installation.";

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
        $days = (int)config('reminder.sale_contract.uploaded_by_sale_engineer.day');
        $type = config('reminder.sale_contract.uploaded_by_sale_engineer.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $weekBefore = Carbon::now()->subDays($days);

        $saleContracts = SaleContract::where('has_installation', true)
                                        ->where('created_at', "<=", $weekBefore)
                                        ->whereDoesntHave('saleContractPdfs', function($query){
                                            $query->where('is_other_docs', true);
                                        })
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
            $remainingJob->inCharges()->attach($saleContract->sale_engineer->id);
        }
    }
}
