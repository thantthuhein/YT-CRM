@extends('layouts.admin')
@section('content')

@can('quotation_show')
<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.quotation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">


            <div class="form-group">
                <a class="btn btn-create" href="{{ url("/admin/quotations/$quotation->id/quotation-revisions/create") }}">
                    <i class="fas fa-plus-circle"></i> &nbsp; {{ trans('cruds.quotation.fields.add_iteration') }} 
                </a>

                <a class="btn btn-create" href="{{ route('admin.quotations.edit', $quotation->id) }}">
                    <i class="fas fa-edit"></i> &nbsp; {{ trans('cruds.quotation.fields.edit_quotation') }} 
                </a>

                {{-- @if ( $quotation->saleContract == NULL )
                    <a class="btn btn-create" href="{{ route('admin.quotations.sale-contracts.create', [$quotation]) }}">
                        Create Sales Contract
                    </a>
                @else
                    <a class="btn btn-create" href="{{ route('admin.sale-contracts.show', optional($quotation->saleContract)->id) }}">
                        View Sales Contract
                    </a>
                @endif --}}
            </div>

            <table class="en-list table table-borderless table-striped text-white">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.quotation.fields.customer') }}
                        </th>
                        <td>
                            {{ $quotation->customer->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customerPhone.fields.phone_number') }}s
                        </th>
                        <td>
                            @if ($quotation->customer->customerPhones)
                                @foreach ($quotation->customer->customerPhones as $contact)
                                    {{$contact->phone_number}},&nbsp;
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotation.fields.location') }}
                        </th>
                        <td>
                            {{ $quotation->enquiries->location ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotation.fields.sales_engineer') }}
                        </th>
                        <td>
                            {{ $quotation->sales_engineer ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotation.fields.number') }}
                        </th>
                        <td>
                            {{ $quotation->number ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotation.fields.status') }}
                        </th>
                        <td>
                            {{ ucfirst($quotation->status) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotation.fields.customer_address') }}
                        </th>
                        <td>
                            {{ $quotation->customer_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotation.fields.created_by') }}
                        </th>
                        <td>
                            {{ $quotation->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotation.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $quotation->updated_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{-- {{ trans('cruds.quotation.fields.iteration_number') }} --}}
                            Iterations
                        </th>
                        <td>
                            @foreach ($quotation->quotationRevisions()->orderBy('created_at','desc')->get() as $quotationRevision)
                                <div class="card display-card my-3">
                                    <div class="d-flex py-4">
                                        <div>
                                            <p class="font-weight-bold">
                                                Quotation Revision - 
                                                @if ($quotationRevision->quotation_revision === NULL)
                                                    First Quotation
                                                @else
                                                    {{ $quotationRevision->quotation_revision }}
                                                @endif
                                            </p>
                                        </div>
    
                                        <div class="ml-auto">
    
                                            <a 
                                            class="btn btn-create btn-sm" 
                                            href="{{ route('admin.quotation-revisions.edit', $quotationRevision->id) }}">
                                                <i class="fas fa-edit"></i> Edit Revised Quotation
                                            </a>
    
                                            <a 
                                            class="btn btn-create btn-sm ml-3" 
                                            href="{{ url("admin/quotations/$quotation->id/follow-ups/create?quotation_revision_id=$quotationRevision->id") }}">
                                                <i class="fas fa-hourglass-end"></i> Add Follow Up
                                            </a>
    
                                        </div>
    
                                    </div>
    
                                    <div class="container pl-0">
                                        <div class="row">
    
                                            <div class="col-4">
                                                <p>Status - {{ ucfirst($quotationRevision->status) }}</p>
                                            </div>
    
                                            <div class="col-4">
                                                <p>Quoted Date - {{ $quotationRevision->quoted_date }}</p>
                                            </div>
    
                                            <div class="col-4">
                                                <p>Quotation PDF - 
                                                    &nbsp;&nbsp;
                                                    @if ($quotationRevision->quotation_pdf == null)
                                                        <small>None</small>
                                                    @else
                                                        <a 
                                                        class="btn btn-sm btn-create" target="_blank" 
                                                        href="{{ $quotationRevision->quotation_pdf }}">
                                                            <i class="far fa-eye"></i> View
                                                        </a>
                                                    @endif
                                                </p>
                                            </div>
    
                                        </div>
                                    </div>
    
                                    @if ($quotationRevision->followUps->isEmpty())
                                        <p>No Follow Up Records Yet</p>
                                    @else
                                        <p class="font-weight-bold">Follow Up List</p>
                                        
                                        <table>
                                            <tr>
                                                <th>{{ trans('cruds.followUp.fields.contact_person') }}</th>
                                                <th>{{ trans('cruds.followUp.fields.contact_number') }}</th>
                                                <th>{{ trans('cruds.followUp.fields.follow_up_by') }}</th>
                                                <th>{{ trans('cruds.followUp.fields.follow_up_time') }}</th>
                                                <th>{{ trans('cruds.followUp.fields.status') }}</th>
                                                <th>{{ trans('cruds.followUp.fields.remark') }}</th>
                                                <th></th>
                                            </tr>
                                            @foreach ($quotationRevision->followUps()->latest()->get() as $followUp)
    
                                                <tr>
                                                    <td>{{ $followUp->contact_person }}</td>
                                                    <td>{{ $followUp->contact_number }}</td>
                                                    <td>{{ $followUp->user->name }}</td>
                                                    <td>{{ $followUp->follow_up_time }}</td>
                                                    <td>{{ ucfirst($followUp->status) }}</td>
                                                    <td>{!! $followUp->remark !!}</td>
                                                    <td>
                                                        <a 
                                                        class="btn btn-create btn-sm ml-3" 
                                                        href="{{ route('admin.follow-ups.edit', $followUp->id) }}">
                                                            <i class="fas fa-edit"></i> Edit Follow Up
                                                        </a>
                                                    </td>
                                                </tr>
    
                                            @endforeach
                                        </table>
                                    @endif
                                </div>

                            @endforeach
                        </td>
                    </tr>

                </tbody>
            </table>
            
            <a class="btn btn-create" href="{{ route('admin.quotations.index') }}">
                <i class="fas fa-arrow-circle-left"></i> &nbsp; {{ trans('global.back_to_list') }}
            </a>

        </div>


    </div>
</div>
@endcan

@endsection