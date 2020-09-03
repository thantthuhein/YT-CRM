@extends('layouts.admin')
@section('content')
@can('quotation_revision_create')
    <div style="margin: 10px 30px;" class="row">
        <div class="col-lg-12 p-0">
            <a class="btn btn-success" href="{{ route("admin.quotation-revisions.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.quotationRevision.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card content-card">
    <div class="card-header">
        {{ trans('cruds.quotationRevision.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-QuotationRevision">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.quotation_revision') }}
                        </th>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.quotation') }}
                        </th>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.quoted_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.quotation_pdf') }}
                        </th>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.updated_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotationRevisions as $key => $quotationRevision)
                        <tr data-entry-id="{{ $quotationRevision->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $quotationRevision->id ?? '' }}
                            </td>
                            <td>
                                {{ $quotationRevision->quotation_revision ?? '' }}
                            </td>
                            <td>
                                {{ $quotationRevision->quotation->number ?? '' }}
                            </td>
                            <td>
                                {{ $quotationRevision->quoted_date ?? '' }}
                            </td>
                            <td>
                                <a href="{{url('/admin/quotation-revisions/view_pdf', $quotationRevision->id)}}" target="_blank">Preview</a>

                                {{-- @if($quotationRevision->quotation_pdf)
                                    <a href="{{ $quotationRevision->quotation_pdf->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif --}}
                            </td>
                            <td>
                                {{ App\QuotationRevision::STATUS_SELECT[$quotationRevision->status] ?? '' }}
                            </td>
                            <td>
                                {{ $quotationRevision->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $quotationRevision->updated_by->name ?? '' }}
                            </td>
                            <td>
                                @can('quotation_revision_show')
                                    <a class="btn btn-sm btn-primary d-block my-1" href="{{ route('admin.quotation-revisions.show', $quotationRevision->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('quotation_revision_edit')
                                    <a class="btn btn-sm btn-info d-block my-1" href="{{ route('admin.quotation-revisions.edit', $quotationRevision->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('quotation_revision_delete')
                                    <form action="{{ route('admin.quotation-revisions.destroy', $quotationRevision->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('global.delete') }}">
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
@can('quotation_revision_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.quotation-revisions.massDestroy') }}",
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
  $('.datatable-QuotationRevision:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection