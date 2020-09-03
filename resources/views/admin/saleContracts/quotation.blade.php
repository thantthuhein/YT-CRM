
<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-Quotation">
        <thead>
            <tr>
                <th width="10">

                </th>
                <th>
                    {{ trans('cruds.quotation.fields.id') }}
                </th>
                <th>
                    {{ trans('cruds.quotation.fields.customer') }}
                </th>
                <th>
                    {{ trans('cruds.quotation.fields.enquiries') }}
                </th>
                <th>
                    {{ trans('cruds.quotation.fields.number') }}
                </th>
                <th>
                    {{ trans('cruds.quotation.fields.customer_address') }}
                </th>
                <th>
                    {{ trans('cruds.quotation.fields.created_by') }}
                </th>
                <th>
                    {{ trans('cruds.quotation.fields.updated_by') }}
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotations as $key => $quotation)
                <tr data-entry-id="{{ $quotation->id }}">
                    <td>

                    </td>
                    <td>
                        {{ $quotation->id ?? '' }}
                    </td>
                    <td>
                        {{ $quotation->customer->name ?? '' }}
                    </td>
                    <td>
                        {{ $quotation->enquiries->location ?? '' }}
                    </td>
                    <td>
                        {{ $quotation->number ?? '' }}
                    </td>
                    <td>
                        {{ $quotation->customer_address ?? '' }}
                    </td>
                    <td>
                        {{ $quotation->created_by->name ?? '' }}
                    </td>
                    <td>
                        {{ $quotation->updated_by->name ?? '' }}
                    </td>
                    <td>
                        
                        {{-- @if(!$quotation->saleContract) --}}
                            <a class="btn btn-sm btn-create d-block my-1" href="{{ route('admin.quotations.sale-contracts.create', ['quotation' => $quotation]) }}">
                                Create Sale Contract
                            </a>
                        {{-- @endif --}}

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>