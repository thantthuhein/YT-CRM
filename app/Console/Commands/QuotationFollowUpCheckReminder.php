<?php

namespace App\Console\Commands;

use App\Quotation;
use App\RemainingJob;
use App\ReminderType;
use Carbon\Carbon;
use Illuminate\Console\Command;

class QuotationFollowUpCheckReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check follow up after the quotation has been submitted.';

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
        $days = (int)config('reminder.quotation.followup.day');
        $type = config('reminder.quotation.followup.type');

        $reminderType = ReminderType::where('type', $type)->first();

        $weekBefore = Carbon::now()->subDays($days);

        $quotations = Quotation::whereHas('quotationRevisions', function($query) use($weekBefore){
                                    $query->where('quoted_date', "<=", $weekBefore);
                                })
                                ->doesnthave('quotationRevisions.followUps')
                                ->whereIn('status', ['pending', 'possible'])
                                ->cursor();
        
        foreach($quotations as $quotation){
            $remainingJob = RemainingJob::create([
                'reminder_type_id' => $reminderType->id,
            ]);

            $remainingJob->attachMorph($quotation);
            $remainingJob->attachMorph($quotation->quotationRevisions()->first());

            /**
             * attach in charge user
             *
             */
            $remainingJob->inCharges()->attach($quotation->enquiry()->sale_engineer_id);
        }
    }
}
