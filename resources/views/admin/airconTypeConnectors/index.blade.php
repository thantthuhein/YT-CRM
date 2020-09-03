@extends('layouts.admin')
@section('content')
@can('aircon_type_connector_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.aircon-type-connectors.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.airconTypeConnector.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.airconTypeConnector.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AirconTypeConnector">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.airconTypeConnector.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.airconTypeConnector.fields.enquiries') }}
                        </th>
                        <th>
                            {{ trans('cruds.airconTypeConnector.fields.aircon_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($airconTypeConnectors as $key => $airconTypeConnector)
                        <tr data-entry-id="{{ $airconTypeConnector->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $airconTypeConnector->id ?? '' }}
                            </td>
                            <td>
                                {{ $airconTypeConnector->enquiries->location ?? '' }}
                            </td>
                            <td>
                                @foreach($airconTypeConnector->aircon_types as $key => $item)
                                    <span class="badge badge-info">{{ $item->type }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('aircon_type_connector_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.aircon-type-connectors.show', $airconTypeConnector->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('aircon_type_connector_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.aircon-type-connectors.edit', $airconTypeConnector->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('aircon_type_connector_delete')
                                    <form action="{{ route('admin.aircon-type-connectors.destroy', $airconTypeConnector->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('aircon_type_connector_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.aircon-type-connectors.massDestroy') }}",
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
  $('.datatable-AirconTypeConnector:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection