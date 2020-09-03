<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\CompletingRemainingJobService;

class CompletingWarrantyEstimatedDateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $warrantyClaim;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($warrantyClaim)
    {
        $this->warrantyClaim = $warrantyClaim;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type = config('reminder.warranty.warranty_estimated_date.type');
        
        $remainingJob = Auth::user()->remainingJobs()
                                        ->unCompletedJobs()
                                        ->filterWithType($type)
                                        ->warrantyClaimMorph($this->warrantyClaim->id)
                                        ->with('jobMorphs')
                                        ->first();
                                        
        if($remainingJob)
        {
            $invoke = new CompletingRemainingJobService;
            $invoke($remainingJob);
        }
    }
}
