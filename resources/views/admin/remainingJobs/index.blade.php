@extends('layouts.admin')
@section('content')
<div class="card card-body content-card display-card">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" 
                id="remaining-jobs-tab" 
                data-toggle="tab" href="#remaining-jobs" 
                role="tab" aria-selected="true">
                Remaining Jobs List <span style="color:red">( {{ count($remainingJobs) }} )</span>
            </a>
            <a class="nav-item nav-link" 
                id="reminder-jobs-tab" 
                data-toggle="tab" href="#reminder-jobs" 
                role="tab" aria-selected="false">
                Reminder Jobs List <span style="color:red">( {{ count($reminderJobs) }} )</span>
            </a>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" 
            id="remaining-jobs" role="tabpanel" aria-labelledby="session-tab">
            @include('admin.remainingJobs.remainingJobsList')
        </div>
        <div class="tab-pane fade show" 
            id="reminder-jobs" role="tabpanel" aria-labelledby="session-tab">
            @include('admin.remainingJobs.reminderJobsList')
        </div>
    </div>
</div>
@endsection