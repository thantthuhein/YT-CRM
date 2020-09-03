<?php

namespace App\Jobs;

use App\RemainingJob;
use App\Services\CompletingRemainingJobService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CompletingFollowUpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $quotation;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($quotation)
    {
        $this->quotation = $quotation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $quotation = $this->quotation;
        $remainingJob = Auth::user()->remainingJobs()
                                        ->unCompletedJobs()
                                        ->quotationMorph($quotation->id)
                                        ->with('jobMorphs')
                                        ->first();
        if($remainingJob)
        {
            $invoke = new CompletingRemainingJobService;
            $invoke($remainingJob);
        }
    }
}
