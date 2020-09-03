<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\CompletingRemainingJobService;

class CompletingSaleContractUploadedBySaleEngineerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $saleContract;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($saleContract)
    {
        $this->saleContract = $saleContract;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type = config('reminder.sale_contract.uploaded_by_sale_engineer.type');
        
        $remainingJob = Auth::user()->remainingJobs()
                                        ->unCompletedJobs()
                                        ->filterWithType($type)
                                        ->saleContractMorph($this->saleContract->id)
                                        ->with('jobMorphs')
                                        ->first();
                                        
        if($remainingJob)
        {
            $invoke = new CompletingRemainingJobService;
            $invoke($remainingJob);
        }
    }
}
