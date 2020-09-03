@extends('layouts.admin')
@section('content')
@can('hand_over_pdf_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.hand-over-pdfs.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.handOverPdf.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.handOverPdf.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-HandOverPdf">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.inhouse_installation') }}
                        </th>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.url') }}
                        </th>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.file_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($handOverPdfs as $key => $handOverPdf)
                        <tr data-entry-id="{{ $handOverPdf->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $handOverPdf->id ?? '' }}
                            </td>
                            <td>
                                {{ $handOverPdf->inhouse_installation->estimate_start_date ?? '' }}
                            </td>
                            <td>
                                @if($handOverPdf->url)
                                    <a href="{{ $handOverPdf->url->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ App\HandOverPdf::FILE_TYPE_SELECT[$handOverPdf->file_type] ?? '' }}
                            </td>
                            <td>
                                @can('hand_over_pdf_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.hand-over-pdfs.show', $handOverPdf->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('hand_over_pdf_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.hand-over-pdfs.edit', $handOverPdf->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('hand_over_pdf_delete')
                                    <form action="{{ route('admin.hand-over-pdfs.destroy', $handOverPdf->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('hand_over_pdf_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.hand-over-pdfs.massDestroy') }}",
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
  $('.datatable-HandOverPdf:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection