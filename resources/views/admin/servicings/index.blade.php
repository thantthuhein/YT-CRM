@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        Servicing Index
    </div>

    <div class="card-body">
        <div class="container pl-0">

            {{-- <div class="row">

                <div class="col mb-5">

                    <div class="d-flex">
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.servicing-complementaries.index') }}">Servicing Complementary</a>
                        <a class="btn btn-sm btn-primary ml-1" href="{{ route('admin.servicing-contracts.index') }}">Servicing Contracts</a>

                        <a href="{{ route('admin.servicing-setups.index') }}" 
                        class="btn btn-sm btn-primary ml-auto"
                        >
                            Maintenance List
                        </a>

                    </div>

                </div>
            </div> --}}

            <div class="row">
                <div class="col-12">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-complementaries-tab" data-toggle="tab" href="#nav-complementaries" role="tab" aria-controls="nav-complementaries" aria-selected="true">Complementaries</a>

                            <a class="nav-item nav-link" id="nav-contracts-tab" data-toggle="tab" href="#nav-contracts" role="tab" aria-controls="nav-contracts" aria-selected="false">Contracts</a>
                        </div>
                    </nav>
        
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-complementaries" role="tabpanel" aria-labelledby="nav-complementaries-tab">


                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>First Maintenance</th>
                                        <th>Second Maintenance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($servicingComplemetaries as $complementary)
                                        <tr>
                                            <td>{{ $complementary->project->name }}</td>
                                            <td>{{ $complementary->first_maintenance_date }}</td>
                                            <td>{{ $complementary->second_maintenance_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade" id="nav-contracts" role="tabpanel" aria-labelledby="nav-contracts-tab">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Interval</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Remark Date</th>
                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($servicingContracts as $contract)
                                        <tr>
                                            <td>{{ $contract->project->name }}</td>
                                            <td>{{ $contract->interval }}</td>
                                            <td>{{ $contract->contract_start_date }}</td>
                                            <td>{{ $contract->contract_end_date }}</td>
                                            <td>{{ $contract->remark }}</td>
                                            {{-- <td>
                                                <a 
                                                href="{{ route('admin.servicing-setups.create', ['project_id' => $contract->project_id, 'request_type' => 'contract']) }}" class="btn btn-sm btn-primary">
                                                Set Up Maintenance</a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>                            

                        </div>
                    </div>

                </div>
            </div>
            
        </div>


    </div>
</div>
@endsection