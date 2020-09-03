<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\CompletingRemainingJobService;

class CompletingActualInstallationReportPdfUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $inHouseInstallation;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($inHouseInstallation)
    {
        $this->inHouseInstallation = $inHouseInstallation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type = config('reminder.sale_contract.actual_installation_report.type');
        
        $remainingJob = Auth::user()->remainingJobs()
                                        ->unCompletedJobs()
                                        ->filterWithType($type)
                                        ->inHouseInstallationMorph($this->inHouseInstallation->id)
                                        ->with('jobMorphs')
                                        ->first();
                                        
        if($remainingJob)
        {
            $invoke = new CompletingRemainingJobService;
            $invoke($remainingJob);
        }

    }
}
