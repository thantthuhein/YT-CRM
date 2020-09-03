<?php

namespace App\Http\Controllers\Admin;

use App\RemainingJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemainingJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('for') && !empty($request->for) && $request->for == 'today') {

            $remainingJobs = auth()->user()
            ->remainingJobs()
            ->whereDate('remaining_jobs.created_at', today())
            ->latest()
            ->get()
            ->map(function ($remainingJob) {
                return $remainingJob->load('reminderType');
            });

        } else {

            $remainingJobs = auth()->user()->remainingJobs->map(function($remainingJob){
                return $remainingJob->load('reminderType');
            });

        }

        $reminderJobs = auth()->user()->reminderJobsList()->all();

        return view('admin.remainingJobs.index', compact('remainingJobs', 'reminderJobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RemainingJob  $remainingJob
     * @return \Illuminate\Http\Response
     */
    public function show(RemainingJob $remainingJob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RemainingJob  $remainingJob
     * @return \Illuminate\Http\Response
     */
    public function edit(RemainingJob $remainingJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RemainingJob  $remainingJob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RemainingJob $remainingJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RemainingJob  $remainingJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemainingJob $remainingJob)
    {
        //
    }
}
