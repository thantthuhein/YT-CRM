@extends('layouts.admin')
@section('content')
@can('user_branch_connector_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.user-branch-connectors.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.userBranchConnector.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.userBranchConnector.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-UserBranchConnector">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.userBranchConnector.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.userBranchConnector.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.userBranchConnector.fields.branch') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userBranchConnectors as $key => $userBranchConnector)
                        <tr data-entry-id="{{ $userBranchConnector->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $userBranchConnector->id ?? '' }}
                            </td>
                            <td>
                                {{ $userBranchConnector->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $userBranchConnector->branch->name ?? '' }}
                            </td>
                            <td>
                                @can('user_branch_connector_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.user-branch-connectors.show', $userBranchConnector->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_branch_connector_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.user-branch-connectors.edit', $userBranchConnector->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_branch_connector_delete')
                                    <form action="{{ route('admin.user-branch-connectors.destroy', $userBranchConnector->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('user_branch_connector_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-branch-connectors.massDestroy') }}",
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
  $('.datatable-UserBranchConnector:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection