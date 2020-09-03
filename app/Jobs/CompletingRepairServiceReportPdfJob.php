<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\CompletingRemainingJobService;

class CompletingRepairServiceReportPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $repair;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($repair)
    {
        $this->repair = $repair;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type = config('reminder.repair.repair_service_report.type');
        
        $remainingJob = Auth::user()->remainingJobs()
                                        ->unCompletedJobs()
                                        ->filterWithType($type)
                                        ->repairMorph($this->repair->id)
                                        ->with('jobMorphs')
                                        ->first();
                                        
        if($remainingJob)
        {
            $invoke = new CompletingRemainingJobService;
            $invoke($remainingJob);
        }
    }
}
