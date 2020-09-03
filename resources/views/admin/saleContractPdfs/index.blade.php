@extends('layouts.admin')
@section('content')
@can('sale_contract_pdf_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.sale-contract-pdfs.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.saleContractPdf.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.saleContractPdf.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SaleContractPdf">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.sale_contract') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.iteration') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.url') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.uploaded_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saleContractPdfs as $key => $saleContractPdf)
                        <tr data-entry-id="{{ $saleContractPdf->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $saleContractPdf->id ?? '' }}
                            </td>
                            <td>
                                {{ $saleContractPdf->sale_contract->has_installation ?? '' }}
                            </td>
                            <td>
                                {{ $saleContractPdf->iteration ?? '' }}
                            </td>
                            <td>
                                @if($saleContractPdf->url)
                                    <a href="{{ $saleContractPdf->url->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $saleContractPdf->title ?? '' }}
                            </td>
                            <td>
                                {{ $saleContractPdf->uploaded_by->name ?? '' }}
                            </td>
                            <td>
                                @can('sale_contract_pdf_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sale-contract-pdfs.show', $saleContractPdf->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('sale_contract_pdf_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sale-contract-pdfs.edit', $saleContractPdf->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('sale_contract_pdf_delete')
                                    <form action="{{ route('admin.sale-contract-pdfs.destroy', $saleContractPdf->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('sale_contract_pdf_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sale-contract-pdfs.massDestroy') }}",
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
  $('.datatable-SaleContractPdf:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection