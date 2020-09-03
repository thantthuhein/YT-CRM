
<div class="table-responsive ">
    
    <table class="table table-bordered table-striped scrollbar">
        <thead>
            <tr>
                <th width="10" style="display: none;">

                </th>
                <th width="10">

                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.id') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.user') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.enquiries_type') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.type_of_sales') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.customer') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.company') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.project') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.location') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.has_installation') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.has_future_action') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.status') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.created_by') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.updated_by') }}
                </th>
                <th>
                    {{ trans('cruds.enquiry.fields.receiver_name') }}
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($enquiries as $key => $enquiry)
                <tr data-entry-id="{{ $enquiry->id }}">
                    <td style="display: none;"></td>
                    <td>

                    </td>
                    <td>
                        {{ $enquiry->id ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->user->name ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->enquiries_type->type ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->type_of_sales->type ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->customer->name ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->company->name ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->project->name ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->location ?? '' }}
                    </td>
                    <td>
                        {{ App\Enquiry::HAS_INSTALLATION_SELECT[$enquiry->has_installation] ?? '' }}
                    </td>
                    <td>
                        {{ App\Enquiry::HAS_FUTURE_ACTION_SELECT[$enquiry->has_future_action] ?? '' }}
                    </td>
                    <td>
                        {{ App\Enquiry::STATUS_SELECT[$enquiry->status] ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->created_by->name ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->updated_by->name ?? '' }}
                    </td>
                    <td>
                        {{ $enquiry->receiver_name ?? '' }}
                    </td>
                    <td>
                        {{-- @if(!$enquiry->saleContract) --}}
                            <div class="mr-2">
                                @can('enquiry_show')
                                    <a class="btn btn-save" href="{{ route('admin.enquiries.sale-contracts.create', [ 'enquiry' => $enquiry]) }}">
                                        Create Sale Contract
                                    </a>
                                @endcan
                            </div>
                        {{-- @endif --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>