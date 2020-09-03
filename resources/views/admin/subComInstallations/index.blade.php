@extends('layouts.admin')
@section('content')
@can('sub_com_installation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.sub-com-installations.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.subComInstallation.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.subComInstallation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SubComInstallation">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.sale_contract') }}
                        </th>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.rating') }}
                        </th>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.completed_month') }}
                        </th>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.completed_year') }}
                        </th>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.installation_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subComInstallations as $key => $subComInstallation)
                        <tr data-entry-id="{{ $subComInstallation->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $subComInstallation->id ?? '' }}
                            </td>
                            <td>
                                {{ $subComInstallation->sale_contract->has_installation ?? '' }}
                            </td>
                            <td>
                                {{ $subComInstallation->rating ?? '' }}
                            </td>
                            <td>
                                {{ $subComInstallation->completed_month ?? '' }}
                            </td>
                            <td>
                                {{ $subComInstallation->completed_year ?? '' }}
                            </td>
                            <td>
                                {{ $subComInstallation->installation_type ?? '' }}
                            </td>
                            <td>
                                @can('sub_com_installation_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sub-com-installations.show', $subComInstallation->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('sub_com_installation_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sub-com-installations.edit', $subComInstallation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('sub_com_installation_delete')
                                    <form action="{{ route('admin.sub-com-installations.destroy', $subComInstallation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('sub_com_installation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sub-com-installations.massDestroy') }}",
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
  $('.datatable-SubComInstallation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection