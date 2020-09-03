@extends('layouts.admin')
@section('content')
@can('warranty_claim_action_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.warranty-claim-actions.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.warrantyClaimAction.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.warrantyClaimAction.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-WarrantyClaimAction">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.daikin_rep_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.daikin_rep_phone_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.service_report_pdf_ywar_taw') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.service_report_pdf_daikin') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.deliver_order_pdf') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.estimate_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.actual_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.updated_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warrantyClaimActions as $key => $warrantyClaimAction)
                        <tr data-entry-id="{{ $warrantyClaimAction->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $warrantyClaimAction->id ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaimAction->daikin_rep_name ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaimAction->daikin_rep_phone_number ?? '' }}
                            </td>
                            <td>
                                @if($warrantyClaimAction->service_report_pdf_ywar_taw)
                                    <a href="{{ $warrantyClaimAction->service_report_pdf_ywar_taw->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($warrantyClaimAction->service_report_pdf_daikin)
                                    <a href="{{ $warrantyClaimAction->service_report_pdf_daikin->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($warrantyClaimAction->deliver_order_pdf)
                                    <a href="{{ $warrantyClaimAction->deliver_order_pdf->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $warrantyClaimAction->estimate_date ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaimAction->actual_date ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaimAction->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaimAction->updated_by->name ?? '' }}
                            </td>
                            <td>
                                @can('warranty_claim_action_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.warranty-claim-actions.show', $warrantyClaimAction->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('warranty_claim_action_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.warranty-claim-actions.edit', $warrantyClaimAction->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('warranty_claim_action_delete')
                                    <form action="{{ route('admin.warranty-claim-actions.destroy', $warrantyClaimAction->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('warranty_claim_action_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.warranty-claim-actions.massDestroy') }}",
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
  $('.datatable-WarrantyClaimAction:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection