@extends('layouts.admin')
@section('content')
{{-- @can('servicing_setup_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.servicing-setups.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.servicingSetup.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('cruds.servicingSetup.title_singular') }} {{ trans('global.list') }}
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
                            {{ trans('cruds.servicingSetup.fields.project') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.is_major') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.estimated_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.actual_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.request_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.service_report_pdf') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.team_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                       $order = order(request()->page ?? 1, $servicingSetups->perPage())
                    @endphp
                    @foreach($servicingSetups as $key => $servicingSetup)
                    <tr data-entry-id="{{ $servicingSetup->id }}" 
                        class="{{ \Carbon\Carbon::parse($servicingSetup->estimated_date)->diffInDays(\Carbon\Carbon::now()) <= 1 && $servicingSetup->status == 'Pending' ? 'text-danger' : '' }}"
                        >
                            <td>
                                <p class="d-flex">
                                    {{ $order++ }}
                                    @if (\Carbon\Carbon::parse($servicingSetup->estimated_date)->diffInDays(\Carbon\Carbon::now()) <= 1 && $servicingSetup->status == 'Pending')
                                    <i class="fas fa-exclamation-circle mt-1 ml-2"></i>
                                    @endif
                                </p>
                            </td>
                            <td>
                                {{ $servicingSetup->created_at->format('M-d-Y') }}
                            </td>
                            <td>
                                {{ $servicingSetup->project->name ?? '' }}
                            </td>
                            <td>
                                {{ App\ServicingSetup::IS_MAJOR_RADIO[$servicingSetup->is_major] ?? '' }}
                            </td>
                            <td>
                                {{ $servicingSetup->status ?? '' }}
                            </td>
                            <td>
                                {{ $servicingSetup->estimated_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingSetup->actual_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingSetup->request_type ?? '' }}
                            </td>
                            <td>
                                @if($servicingSetup->service_report_pdf)
                                    <a href="{{ $servicingSetup->service_report_pdf }}" target="_blank">
                                        {{ trans('global.view_file') }} <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ ucfirst($servicingSetup->team_type) ?? '' }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    @can('servicing_setup_show')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.servicing-setups.show', $servicingSetup->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
    
                                    @can('servicing_setup_edit')
                                        {{-- <a class="btn btn-sm btn-info d-block mt-1" href="{{ route('admin.servicing-setups.edit', $servicingSetup->id) }}">
                                            {{ trans('global.edit') }}
                                        </a> --}}
                                    @endcan
    
                                    @can('servicing_setup_delete')
                                        <form action="{{ route('admin.servicing-setups.destroy', $servicingSetup->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        <div class="my-3">
            {{ $servicingSetups->links() }}
        </div>

    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
//     $(function () {
//   let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
// @can('servicing_setup_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('admin.servicing-setups.massDestroy') }}",
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
//   $('.datatable-ServicingSetup:not(.ajaxTable)').DataTable({ buttons: dtButtons })
//     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
//         $($.fn.dataTable.tables(true)).DataTable()
//             .columns.adjust();
//     });
// });

</script>
@endsection