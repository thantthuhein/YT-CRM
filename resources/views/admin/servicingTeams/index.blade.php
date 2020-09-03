@extends('layouts.admin')
@section('content')
@can('servicing_team_create')
    <div style="margin-left: 30px;" class="my-3">
        <a class="btn btn-create" href="{{ route("admin.servicing-teams.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.servicingTeam.title_singular') }}
        </a>
    </div>
@endcan
<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('cruds.servicingTeam.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.leader_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.phone_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.man_power') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.is_active') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.updated_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $servicingTeams->perPage())
                    @endphp
                    @foreach($servicingTeams as $key => $servicingTeam)
                        <tr>
                            <td>{{$order++}}</td>
                            <td>
                                {{ $servicingTeam->leader_name ?? '' }}
                            </td>
                            <td>
                                {{ $servicingTeam->phone_number ?? '' }}
                            </td>
                            <td>
                                {{ $servicingTeam->man_power ?? '' }}
                            </td>
                            <td>
                                {{ App\ServicingTeam::IS_ACTIVE_RADIO[$servicingTeam->is_active] ?? '' }}
                            </td>
                            <td>
                                {{ $servicingTeam->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $servicingTeam->updated_by->name ?? '' }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    @can('servicing_team_show')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.servicing-teams.show', $servicingTeam->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
    
                                    @can('servicing_team_edit')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.servicing-teams.edit', $servicingTeam->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
    
                                    @can('servicing_team_delete')
                                        <form action="{{ route('admin.servicing-teams.destroy', $servicingTeam->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-sm btn-create text-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $servicingTeams->links() }}
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('servicing_team_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.servicing-teams.massDestroy') }}",
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
  $('.datatable-ServicingTeam:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection