@extends('layouts.admin')
@section('content')
@can('sale_contract_create')


<div class="d-flex">
    <a 
    class="btn btn-create ml-auto mb-3" 
    href="{{ route("admin.excel-exports.sale-contracts") }}"
    style="margin-right: 28px;"
    onclick="return confirm('Export excel for sale contract?');"
    >
        Excel Export
    </a>
</div>

{{-- {{ route("admin.sale-contracts.choose-quotation-enquiry") }} --}}

@endcan
<div class="card content-card display-card">
    <div class="card-header text-white">
        {{ trans('cruds.saleContract.title') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>
                            {{ trans('cruds.saleContract.fields.created_at') }}
                        </th>
                        <th>
                            Customer Name
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                            Location
                        </th>
                        <th>
                            Project Name
                        </th>
                        <th>
                            {{ trans('cruds.saleContract.fields.has_installation') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContract.fields.installation_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContract.fields.payment_terms') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContract.fields.current_payment_step') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContract.fields.payment_status') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContract.fields.created_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                       $order = order(request()->page ?? 1, $saleContracts->perPage())
                    @endphp
                    @foreach($saleContracts as $key => $saleContract)
                        <tr data-entry-id="{{ $saleContract->id }}">
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                {{ $saleContract->created_at->format('M-d-Y')}}
                            </td>
                            <td>
                                {{$saleContract->customer->name}}
                            </td>
                            
                            <td>
                                {{ $saleContract->morphable_name ?? '' }}
                            </td>
                            <td>
                                {{ optional(optional($saleContract->customer->customerPhones())->first())->phone_number }}
                            </td>
                            <td>
                                {{ $saleContract->customer->enquiries()->first()->location ?? "" }}
                            </td>
                            <td>
                                {{ $saleContract->customer->enquiries()->first()->project->name ?? "" }}
                            </td>
                            <td>
                                {{ App\SaleContract::HAS_INSTALLATION_RADIO[$saleContract->has_installation] ?? '' }}
                            </td>
                            <td>
                                {{ App\SaleContract::INSTALLATION_TYPE_SELECT[$saleContract->installation_type] ?? '' }}
                            </td>
                            <td>
                                {{ $saleContract->payment_terms ?? '' }}
                            </td>
                            <td>
                                {{ $saleContract->current_payment_step ?? '' }}
                            </td>
                            <td>
                                {{ $saleContract->payment_status ?? '' }}
                            </td>
                            <td>
                                {{ $saleContract->created_by->name ?? '' }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    @can('sale_contract_show')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.sale-contracts.show', $saleContract->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    {{-- @can('sale_contract_delete')
                                        <form action="{{ route('admin.sale-contracts.destroy', $saleContract->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-sm text-danger btn-create" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan --}}
                                </div>

                                {{-- @can('sale_contract_edit')
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.sale-contracts.edit', $saleContract->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan --}}                                

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $saleContracts->appends(array_filter(request()->except('page')))->links()}}
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('sale_contract_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sale-contracts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-SaleContract:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection