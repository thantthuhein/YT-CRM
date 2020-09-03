@extends('layouts.admin')
@section('content')

@can('quotation_access')
<div class="container ml-3 my-3 mr-3">
    <div class="row">
        <div class="col">

            <div class="d-flex">
                <form class="form-inline" action="{{ route('admin.quotations.index') }}" method="GET" id="status_select">
                    <label class="label text-white">Status: &nbsp;&nbsp;</label>
            
                    <select name="selected_status" onchange="selectStatus()" id="selected_status" form="status_select" class="form-control">
                        <option value="all">All</option>
                        @foreach(App\Quotation::STATUS_SELECT as $key => $value)
                            <option 
                            value="{{ $key }}" 
                            {{ (request()->selected_status ?? 'possible') === (string) $key ? 'selected' : '' }}
                            >
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>

                    <label class="label text-white ml-2">Sales Engineer: </label>
                    <select name="sales_engineer" onchange="selectStatus()" id="sales_engineer" form="status_select" class="form-control ml-2">
                        @foreach($salesEngineers as $key => $value)
                            <option value="{{ $key }}"
                            {{ request()->sales_engineer === (string) $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    
                    <input class="form-control rounded-pill ml-5" type="search" placeholder="Type quotation number" aria-label="Search" name="quotation_number" style="height:26px;" value="{{ request()->has('quotation_number') ? request()->quotation_number : '' }}" >
                    <button class="btn btn-success btn-sm rounded-pill py-1 ml-2" type="submit">Search</button>
                    
                </form>
                
            </div>

        </div>
    </div>
</div>

<div class="card content-card display-card">
    <div class="card-header text-white">
        {{ trans('cruds.quotation.title_singular') }} {{ trans('global.list') }}
    </div>


    <div class="card-body">
        
        @if ( count($quotations) == 0)
            <h3 class="text-white text-center">No Quotations Found</h3>
        @else

            <div class="table-responsive scrollbar">
                
                <table class="en-list table table-borderless table-striped scrollbar">

                    <thead>
                        <tr>
                            <th>

                            </th>
                            <th>
                                Created At
                            </th>
                            <th>
                                {{ trans('cruds.quotation.fields.customer') }}
                            </th>
                            <th>
                                {{ trans('cruds.quotation.fields.location') }}
                            </th>
                            <th>
                                {{ trans('cruds.quotation.fields.sales_engineer') }}
                            </th>
                            <th>
                                {{ trans('cruds.quotation.fields.number') }}
                            </th>
                            <th>
                                {{ trans('cruds.quotation.fields.status') }}
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
                        @php
                            $order = order(request()->page ?? 1, $quotations->perPage())
                        @endphp
                        @foreach($quotations as $key => $quotation)
                            <tr data-entry-id="{{ $quotation->id }}">
                                <td>
                                    {{ $order++ }}
                                </td>
                                <td>
                                    {{ $quotation->created_at->format('M-d-Y')}}
                                </td>
                                <td>
                                    {{ $quotation->customer->name ?? '' }}
                                </td>
                                <td>
                                    {{ $quotation->enquiries->location ?? '' }}
                                </td>
                                <td>
                                    {{ $quotation->sales_engineer ?? '' }}
                                </td>
                                <td>
                                    {{ $quotation->number ?? '' }}
                                </td>
                                <td>
                                    {{ ucfirst($quotation->status) ?? '' }}
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
                                    <div class="d-flex">
                                        
                                        @can('quotation_show')
                                            <a class="btn btn-create btn-sm mr-2" href="{{ route('admin.quotations.show', $quotation->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @if ( $quotation->saleContract == NULL )
                                        <a class="btn btn-create btn-sm mr-2 d-block" href="{{ route('admin.quotations.sale-contracts.create', [$quotation]) }}">
                                            Create Sales Contract
                                        </a>
                                        @else
                                        <a class="btn btn-create btn-sm mr-2 d-block" href="{{ route('admin.sale-contracts.show', optional($quotation->saleContract)->id) }}">
                                            View Sales Contract
                                        </a>
                                        @endif

                                        {{-- @can('quotation_delete')
                                            <form action="{{ route('admin.quotations.destroy', $quotation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display:inline;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-sm text-danger btn-create" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan --}}

                                    </div>

                                    {{-- @can('quotation_edit')
                                        <a class="btn btn-create" href="{{ route('admin.quotations.edit', $quotation->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan --}}

                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div class="mt-3">
                    {{ optional($quotations)->appends(['selected_status' => request()->selected_status])->links() }}
                </div>

            </div>

        @endif



    </div>
</div>
@endcan

@endsection

@section('scripts')
@parent
<script>
    function selectStatus(event){
        document.getElementById('status_select').submit();
    }


    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('quotation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.quotations.massDestroy') }}",
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
  $('.datatable-Quotation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection