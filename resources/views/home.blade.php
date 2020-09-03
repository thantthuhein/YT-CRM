@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="/css/app.css"/>
<link rel="stylesheet" href="{{asset('css/auth/dashboard.css')}}">
@endsection

@section('content')

    <!-- Main content -->
    <div class="main-content dashboard-content">
        
        <overview class="overview content-item"></overview>

        <enquiry-type enquiries="{{ $enquiriesType }}" class="enquiry-type content-item"></enquiry-type>
        
        <remaining-tasks 
        view-all-link="{{ route('admin.remaining-jobs.index') }}"
        excel-export-link="{{ route("admin.excel-exports.remaining-jobs") }}"

        class="remaining-tasks content-item">
            @include('admin.remainingJobs.remainingJobsList', ['remainingJobs' => $remainingJobs, 'color' => 'white'])
        </remaining-tasks>
        
        <today-tasks 
        view-all-link="{{ route('admin.remaining-jobs.index', ['for' => 'today']) }}"
        excel-export-link="{{ route("admin.excel-exports.remaining-jobs", ['for' => 'today']) }}"
        class="today-tasks content-item">
            @include('admin.remainingJobs.todayJobsList', ['remainingJobs' => $todayJobs, 'color' => 'white'])
        </today-tasks>
        
        <current-projects class="current-projects content-item">

            @if (!$currentProjects->isEmpty())                 
                @foreach($currentProjects as $currentProject)
                    {{-- <project-list :current-project="{{ $currentProject }}" route-name="{{ route('admin.sale-contracts.show', [$currentProject]) }}"></project-list> --}}
                    @include('currentProject')
                @endforeach
            @else 
                <h5 class="text-center">No Current Projects</h5>
            @endif

        </current-projects>
        
        <pending-quotations-list class="pending-quotations-list content-item">

            @foreach ($pendingQuotations as $pendingQuotation)
                <pending-quotations-list-item 
                quotation-number="{{ $pendingQuotation->number ?? '' }}"
                customer-name="{{ $pendingQuotation->customer->name ?? '' }}"
                sales-engineer="{{ $pendingQuotation->enquiry()->user->name ?? '' }}"
                quotation-date="{{ $pendingQuotation->created_at->format('M-d-Y') ?? '' }}"
                quotation-id="{{ $pendingQuotation->id ?? ''}}"
                >
                </pending-quotations-list-item>
            @endforeach

        </pending-quotations-list>
        
        <our-growth-by-month class="our-growth-by-month content-item"></our-growth-by-month>

        <our-growth-by-year class="our-growth-by-year content-item"></our-growth-by-year>

    </div>
    <!-- /.content -->
@endsection

@section('scripts')
    
@parent

@endsection