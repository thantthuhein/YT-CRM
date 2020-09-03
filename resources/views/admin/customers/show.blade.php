@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.customer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.name') }}
                        </th>
                        <td>
                            {{ $customer->name ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.company') }}
                        </th>
                        <td>
                            @foreach($customer->companies as $key => $company)
                                <span class="label label-info px-2 rounded-pill">{{ $company->name ?? ''}}</span>
                                {{-- <a href="{{ route('admin.companies.show', $company) }}" class="btn btn-sm btn-info rounded-pill">
                                    <i class="fas fa-eye"></i> view
                                </a> --}}
                            @endforeach
                        </td>
                    </tr>                    
                    <tr>
                        <th>Email</th>
                        <td>
                            {{ $customer->email ?? '' }}
                            {{-- {{ $customer->customerEmails }} --}}
                        </td>
                    </tr>
                    <tr>
                        <th>Phone Numbers</th>
                        <td>
                            @foreach ($customer->customerPhones as $phone)
                                {{ $phone->phone_number }} ,&nbsp;
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.address') }}
                        </th>
                        <td>
                            {{ $customer->address ?? 'No Address yet'}}
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>

        <div class="card text-dark">
            <nav>
    
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link {{ session()->has('customer_name') ? '' : 'active' }}" id="nav-enquiries-tab" data-toggle="tab" href="#nav-enquiries" role="tab" aria-controls="nav-enquiries" aria-selected="true">
                        Enquiries
                    </a>
    
                    <a class="nav-item nav-link" id="nav-quotations-tab" data-toggle="tab" href="#nav-quotations" role="tab" aria-controls="nav-quotations" aria-selected="false">
                        Quotations
                    </a>
    
                    <a class="nav-item nav-link" id="nav-sale-contracts-tab" data-toggle="tab" href="#nav-sale-contracts" role="tab" aria-controls="nav-sale-contracts" aria-selected="false">
                        Sale Contracts
                    </a>
    
                    <a class="nav-item nav-link" id="nav-maintenances-tab" data-toggle="tab" href="#nav-maintenances" role="tab" aria-controls="nav-maintenances" aria-selected="false">
                        Maintenances
                    </a>
    
                    <a class="nav-item nav-link" id="nav-repairs-tab" data-toggle="tab" href="#nav-repairs" role="tab" aria-controls="nav-repairs" aria-selected="false">
                        Repairs
                    </a>
    
                    <a class="nav-item nav-link" id="nav-warranty-claims-tab" data-toggle="tab" href="#nav-warranty-claims" role="tab" aria-controls="nav-warranty-claims" aria-selected="false">
                        Warranty Claims
                    </a>                
    
                    <a class="nav-item nav-link {{ session('customer_name') == $customer->name ? 'active show' : '' }}" 
                    id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false">
                        Notes                    
                    </a>
                </div>
    
            </nav>
    
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade {{ session()->has('customer_name') ? '' : 'active show' }}" id="nav-enquiries" role="tabpanel" aria-labelledby="nav-enquiries-tab">
                    @include('admin.customers.enquiries', ['customer' => $customer])
                </div>
    
                <div class="tab-pane fade" id="nav-quotations" role="tabpanel" aria-labelledby="nav-quotations-tab">
                    @include('admin.customers.quotations', ['customer' => $customer])
                </div>
    
                <div class="tab-pane fade" id="nav-sale-contracts" role="tabpanel" aria-labelledby="nav-sale-contracts-tab">
                    @include('admin.customers.saleContracts', ['saleContracts' => $saleContracts])
                </div>
    
                <div class="tab-pane fade" id="nav-maintenances" role="tabpanel" aria-labelledby="nav-maintenances-tab">
                    @include('admin.customers.maintenances', ['customer' => $customer])
                </div>
    
                <div class="tab-pane fade" id="nav-repairs" role="tabpanel" aria-labelledby="nav-repairs-tab">
                    @include('admin.customers.repairs', ['customer' => $customer])
                </div>
    
                <div class="tab-pane fade" id="nav-warranty-claims" role="tabpanel" aria-labelledby="nav-warranty-claims-tab">
                    @include('admin.customers.warranty-claims', ['customer' => $customer])
                </div>
    
                <div class="tab-pane fade {{ session('customer_name') == $customer->name ? 'active show' : '' }}" 
                id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                    {{-- @include('admin.customers.createNote', ['customer' => $customer]) --}}
                    <div class="card">
                        <div class="card-header d-flex">
                            <p class="mr-auto">Notes For: {{ $customer->name }}</p>
                            <div>
                                <a href="{{ route('admin.customers.createNote', $customer) }}" class="btn btn-sm btn-primary rounded-pill"><i class="fas fa-plus-circle"></i> Create New Note</a>
                            </div>
                        </div>
                        @foreach ($customer->notes as $key => $item)     
                            <div class="card my-2">
                                <div class="card-body">
                                    {{ $item->notes ?? '' }}                                    
                                    <div class="d-flex mt-3">
                                        <small class="label label-info rounded-pill px-2">
                                            Created At : {{ $item->created_at->format('D-d-M-Y') ?? '' }}
                                        </small>
                                        <small class="ml-auto label label-info rounded-pill px-2">
                                            Created By: {{ $item->created_by->name ?? ''}}     
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="my-3">
            <a class="btn btn-create" href="{{ route('admin.customers.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>

    </div>
</div>
@endsection