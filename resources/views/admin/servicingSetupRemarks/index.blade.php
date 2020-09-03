
@can('servicing_setup_remark_create')
    
@endcan

<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-RepairRemark">
        <thead>
            <tr>
                <th>
                    {{ trans('cruds.repairRemark.fields.id') }}
                </th>
                <th>
                    Remark
                </th>
                <th>
                    Created By
                </th>
                <th>
                    Last Updated by
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicingSetupRemarks as $key => $servicingSetupRemark)
                <tr data-entry-id="{{ $servicingSetupRemark->id }}">
                    <td>
                        {{ $servicingSetupRemark->id ?? '' }}
                    </td>
                    <td>
                        {{ $servicingSetupRemark->remark ?? '' }}
                    </td>
                    <td>
                        {{ $servicingSetupRemark->created_by->name ?? '' }}
                    </td>
                    <td>
                        {{ $servicingSetupRemark->updated_by->name ?? '' }}
                    </td>
                    <td>
                        @can('repair_remark_edit')
                            <a class="btn btn-default rounded-pill" href="{{ route('admin.servicing-setup-remarks.edit', $servicingSetupRemark->id) }}">
                                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                            </a>
                        @endcan

                        {{-- @can('repair_remark_delete')
                            <form action="{{ route('admin.repair-remarks.destroy', $repairRemark->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                        @endcan --}}

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>



{{-- @section('scripts')
@parent
<script>
    // $(function () {
    //     let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    //     @can('servicing_setup_remark_delete')
    //     let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    //     let deleteButton = {
    //     text: deleteButtonTrans,
    //     url: "{{ route('admin.servicing-setup-remarks.massDestroy') }}",
    //     className: 'btn-danger',
    //     action: function (e, dt, node, config) {
    //       var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
    //           return $(entry).data('entry-id')
    //       });

    //       if (ids.length === 0) {
    //         alert('{{ trans('global.datatables.zero_selected') }}')

    //         return
    //       }

    //       if (confirm('{{ trans('global.areYouSure') }}')) {
    //         $.ajax({
    //           headers: {'x-csrf-token': _token},
    //           method: 'POST',
    //           url: config.url,
    //           data: { ids: ids, _method: 'DELETE' }})
    //           .done(function () { location.reload() })
    //       }
    //     }
    //   }
    //   dtButtons.push(deleteButton)
    // @endcan

    //   $.extend(true, $.fn.dataTable.defaults, {
    //     order: [[ 1, 'desc' ]],
    //     pageLength: 100,
    //   });
    //   $('.datatable-ServicingSetupRemark:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    //     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    //         $($.fn.dataTable.tables(true)).DataTable()
    //             .columns.adjust();
    //     });
    // });

</script>
@endsection --}}