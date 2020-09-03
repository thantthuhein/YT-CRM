@extends('layouts.admin')
@section('content')

<div class="mb-2" style="margin-left:30px;">
    <a href="{{ route('admin.on-calls.create') }}" class="btn btn-create my-3">Add Service Call</a>
</div>

<div class="card content-card display-card text-white">
    <div class="card-header">
        Service Calls
    </div>

    <div class="card-body">
        <div class="container pl-0 table-responsive scrollbar">

            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>
                            Created At
                        </th>
                        <th>
                            Project
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $servicingCalls->perPage())
                    @endphp
                    @foreach ($servicingCalls as $servicingCall)                        
                    <tr>
                        <td>{{ $order++ }}</td>
                        <td>
                            {{ $servicingCall->created_at->format('M-d-Y') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.sale-contracts.show', $servicingCall->oncall->sale_contract->id) }}">
                                {{ $servicingCall->project ? $servicingCall->project->name : 'Go To Sales Contract' }} <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($servicingCall->estimated_date)->format('M-d-Y') }}
                        </td>
                        <td>
                            {{ $servicingCall->request_type }}
                        </td>
                        <td>
                            <a href="{{ route('admin.servicing-setups.show' , $servicingCall->id) }}" class="btn btn-sm btn-create px-2">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="my-2">
                {{ $servicingCalls->links() }}
            </div>
            
        </div>


    </div>
</div>
@endsection