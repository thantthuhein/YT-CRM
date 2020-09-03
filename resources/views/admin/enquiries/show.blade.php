@extends('layouts.admin')
@section('content')
@can('enquiry_show')
<div class="card content-card show-card">
    <div class="card-header enquiry-show show-header text-white">
        {{ trans('global.show') }} Sales {{ trans('cruds.enquiry.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <div class="actions-wrapper mb-3">
                @if (! $enquiry->quotations->isEmpty() )
                    <div>
                        <a style="width:150px;" class="btn btn-create btn-sm"  
                        href="{{ route('admin.quotations.show', optional($enquiry->quotations->first())->id )}}"
                        >
                            {{trans('cruds.quotation.fields.view_quotation')}}
                        </a>
                        <a style="width:150px;" class="btn btn-create btn-sm disabled" 
                        href="#">
                            Create Sales Contract
                        </a>
                    </div>
                @elseif ($enquiry->quotations->isEmpty() && $enquiry->saleContract !== NULL)
                    <div>
                        <a style="width:150px;" class="btn btn-create btn-sm disabled" href="#">
                            {{ trans('global.create_quotation') }}
                        </a>
                        <a style="width:150px;" class="btn btn-create btn-sm" href="{{ route('admin.sale-contracts.show', $enquiry->saleContract->id ) }}">
                            {{trans('cruds.saleContract.fields.view_sale_contract')}}
                        </a>
                    </div>    
                @else
                    <div>
                        <a style="width:150px;" class="btn btn-sm btn-create" href="/admin/quotations/create?enquiry_id={{$enquiry->id}}">
                            {{ trans('global.create_quotation') }}
                        </a>
                        <a style="width:150px;" class="btn btn-create btn-sm" href="{{ route('admin.enquiries.sale-contracts.create', ['enquiry' => $enquiry->id]) }}">
                            Create Sales Contract
                        </a>
                    </div> 
                @endif                
            </div>

            <table class="en-list table table-borderless table-striped">
                <tbody>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.id') }}
                        </th>
                        <td>
                            {{ $enquiry->id }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.user') }}
                        </th>
                        <td>
                            {{ $enquiry->user->name ?? 'Not Assigned Yet' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.enquiries_type') }}
                        </th>
                        <td>
                            {{ $enquiry->enquiries_type->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.type_of_sales') }}
                        </th>
                        <td>
                            {{ $enquiry->type_of_sales->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.customer') }}
                        </th>
                        <td>
                            {{ $enquiry->customer->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email
                        </th>
                        <td>
                            {{ $enquiry->customer->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Phone number
                        </th>

                        <td>
                            {{ implode(", ", $enquiry->customer->customerPhones->pluck('phone_number')->toArray()) ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.company') }}
                        </th>
                        <td>
                            {{ $enquiry->company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.project') }}
                        </th>
                        <td>
                            {{ $enquiry->project->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.location') }}
                        </th>
                        <td>
                            {{ $enquiry->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.has_installation') }}
                        </th>
                        <td>
                            {{ App\Enquiry::HAS_INSTALLATION_SELECT[$enquiry->has_installation] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.has_future_action') }}
                        </th>
                        <td>
                            {{ App\Enquiry::HAS_FUTURE_ACTION_SELECT[$enquiry->has_future_action] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.status') }}
                        </th>
                        <td>
                            {{ App\Enquiry::STATUS_SELECT[$enquiry->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Aircon Types
                        </th>
                        <td>
                            {{ implode(", ",  $enquiry->airconTypes()->pluck('type')->toArray()) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.created_by') }}
                        </th>
                        <td>
                            {{ $enquiry->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $enquiry->updated_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.receiver_name') }}
                        </th>
                        <td>
                            {{ $enquiry->receiver_name }}
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- @if(count($enquiry->quotations) > 0)
                <a class='btn btn-success' href="{{ route('admin.quotations.show', [$enquiry->quotations->first()]) }}"> Related Quotation </a>
            @endif

            @if($enquiry->saleContract)
                <a class='btn btn-success' href="{{ route('admin.sale-contracts.show', [$enquiry->saleContract]) }}"> Related Sale Contract </a>
            @endif --}}

            <div class="form-group">
                <a class="en-list btn btn-sm btn-create text-dark" href="{{ route('admin.enquiries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection