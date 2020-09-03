@extends('layouts.admin')
@section('content')

{{-- @can('servicing_complementary_create')
    
@endcan --}}

<div class="card content-card display-card text-white">
    <div class="card-header">
        Servicing Complementaries {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>
                            Created At
                        </th>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.inhouse_installation') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.project') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.first_maintenance_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.second_maintenance_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $servicingComplementaries->perPage())
                    @endphp
                    @foreach($servicingComplementaries as $key => $servicingComplementary)
                        <tr data-entry-id="{{ $servicingComplementary->id }}">
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                {{ $servicingComplementary->created_at->format('M-d-Y') ?? '' ?? '' }}
                            </td>
                            <td>
                                {{ $servicingComplementary->inhouse_installation->estimate_start_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingComplementary->project->name ?? '' }}
                            </td>
                            <td>
                                {{ $servicingComplementary->first_maintenance_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingComplementary->second_maintenance_date ?? '' }}
                            </td>
                            <td>
                                @can('servicing_complementary_show')
                                    <a class="btn btn-sm btn-create px-2 mr-2" href="{{ route('admin.servicing-complementaries.show', $servicingComplementary->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                {{-- @can('servicing_complementary_edit')
                                    <a class="btn btn-sm btn-info d-block mt-1" href="{{ route('admin.servicing-complementaries.edit', $servicingComplementary->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan --}}

                                {{-- @can('servicing_complementary_delete')
                                    <form action="{{ route('admin.servicing-complementaries.destroy', $servicingComplementary->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-create btn-sm px-2 border-0 text-danger">
                                            {{ trans('global.delete') }}
                                        </button>
                                    </form>
                                @endcan --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $servicingComplementaries->links() }}
            </div>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
//     $(function () {
//   let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
// @can('servicing_complementary_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('admin.servicing-complementaries.massDestroy') }}",
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
//   $('.datatable-ServicingComplementary:not(.ajaxTable)').DataTable({ buttons: dtButtons })
//     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
//         $($.fn.dataTable.tables(true)).DataTable()
//             .columns.adjust();
//     });
// });

</script>
@endsection