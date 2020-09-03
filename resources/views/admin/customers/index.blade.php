@extends('layouts.admin')
@section('content')
@can('customer_create')
    <div class="my-3" style="margin-left:30px;">
        <a class="btn btn-create" href="{{ route("admin.customers.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}
        </a>
    </div>
@endcan
<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('cruds.customer.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>
                            {{ trans('cruds.customer.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.customer.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.customer.fields.address') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $customers->perPage())
                    @endphp
                    @foreach($customers as $key => $customer)
                        <tr>
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                @foreach($customer->companies as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $customer->name ?? '' }}
                            </td>
                            <td>
                                {{ $customer->address ?? '' }}
                            </td>
                            <td>
                                @can('customer_show')
                                    <a class="btn btn-sm btn-create px-2 btn-primary" href="{{ route('admin.customers.show', $customer->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('customer_edit')
                                    <a class="btn btn-sm btn-create px-2 btn-info" href="{{ route('admin.customers.edit', $customer->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                {{-- @can('customer_delete')
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-sm btn-create px-2 text-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{$customers->links()}}
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('customer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.customers.massDestroy') }}",
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
  $('.datatable-Customer:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection