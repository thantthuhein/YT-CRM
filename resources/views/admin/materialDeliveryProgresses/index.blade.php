@extends('layouts.admin')
@section('content')
@can('material_delivery_progress_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.material-delivery-progresses.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.materialDeliveryProgress.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.materialDeliveryProgress.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-MaterialDeliveryProgress">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.inhouse_installation') }}
                        </th>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.progress') }}
                        </th>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.last_updated_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materialDeliveryProgresses as $key => $materialDeliveryProgress)
                        <tr data-entry-id="{{ $materialDeliveryProgress->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $materialDeliveryProgress->id ?? '' }}
                            </td>
                            <td>
                                {{ $materialDeliveryProgress->inhouse_installation->estimate_start_date ?? '' }}
                            </td>
                            <td>
                                {{ $materialDeliveryProgress->progress ?? '' }}
                            </td>
                            <td>
                                {{ $materialDeliveryProgress->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $materialDeliveryProgress->last_updated_by->name ?? '' }}
                            </td>
                            <td>
                                @can('material_delivery_progress_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.material-delivery-progresses.show', $materialDeliveryProgress->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('material_delivery_progress_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.material-delivery-progresses.edit', $materialDeliveryProgress->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('material_delivery_progress_delete')
                                    <form action="{{ route('admin.material-delivery-progresses.destroy', $materialDeliveryProgress->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('material_delivery_progress_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.material-delivery-progresses.massDestroy') }}",
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
  $('.datatable-MaterialDeliveryProgress:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection