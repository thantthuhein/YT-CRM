@extends('layouts.admin')
@section('content')
@can('repair_team_connector_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.repair-team-connectors.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.repairTeamConnector.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.repairTeamConnector.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-RepairTeamConnector">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.repairTeamConnector.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.repairTeamConnector.fields.repair') }}
                        </th>
                        <th>
                            {{ trans('cruds.repairTeamConnector.fields.morphable') }}
                        </th>
                        <th>
                            {{ trans('cruds.repairTeamConnector.fields.morphable_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repairTeamConnectors as $key => $repairTeamConnector)
                        <tr data-entry-id="{{ $repairTeamConnector->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $repairTeamConnector->id ?? '' }}
                            </td>
                            <td>
                                {{ $repairTeamConnector->repair->estimate_date ?? '' }}
                            </td>
                            <td>
                                {{ $repairTeamConnector->morphable ?? '' }}
                            </td>
                            <td>
                                {{ $repairTeamConnector->morphable_type ?? '' }}
                            </td>
                            <td>
                                @can('repair_team_connector_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.repair-team-connectors.show', $repairTeamConnector->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('repair_team_connector_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.repair-team-connectors.edit', $repairTeamConnector->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('repair_team_connector_delete')
                                    <form action="{{ route('admin.repair-team-connectors.destroy', $repairTeamConnector->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('repair_team_connector_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.repair-team-connectors.massDestroy') }}",
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
  $('.datatable-RepairTeamConnector:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection