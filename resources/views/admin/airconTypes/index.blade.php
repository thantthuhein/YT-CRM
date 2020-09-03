@extends('layouts.admin')
@section('content')
@can('aircon_type_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.aircon-types.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.airconType.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.airconType.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AirconType">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.airconType.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.airconType.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.airconType.fields.parent') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($airconTypes as $key => $airconType)
                        <tr data-entry-id="{{ $airconType->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $airconType->id ?? '' }}
                            </td>
                            <td>
                                {{ $airconType->type ?? '' }}
                            </td>
                            <td>
                                {{ $airconType->parent ?? '' }}
                            </td>
                            <td>
                                @can('aircon_type_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.aircon-types.show', $airconType->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('aircon_type_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.aircon-types.edit', $airconType->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('aircon_type_delete')
                                    <form action="{{ route('admin.aircon-types.destroy', $airconType->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('aircon_type_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.aircon-types.massDestroy') }}",
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
  $('.datatable-AirconType:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection