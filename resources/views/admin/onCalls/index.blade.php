@extends('layouts.admin')
@section('content')
<div class="header-card">
    <div class="header-first">
        
        <form action="{{ route('admin.on-calls.index') }}" method="GET">
            <div class="form-group align-items-center" style="display: flex;">
                <label for="status" class="mr-2" style="color: white;">Status</label>
                <select name="status" class="form-control" onchange="this.form.submit()">
                    @foreach($statuses as $key => $status)
                        <option value="{{ $key }}" {{ $key == request()->status ? 'selected' : ""}}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </form>

    </div>
    @can('on_call_create')
        <div>
            <a class="btn btn-create" href="{{ route("admin.on-calls.create") }}">
                {{ trans('global.create') }} {{ trans('cruds.onCall.service_call') }}
            </a>
        </div>
    @endcan
</div>
<div class="card content-card display-card text-white">
    <div class="card-header">        
        Service {{ trans('cruds.enquiry.title') }} {{ trans('global.list') }}
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
                            {{ trans('cruds.onCall.fields.project') }}
                        </th>
                        <th>
                            {{ trans('cruds.onCall.fields.service_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.onCall.fields.customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.onCall.fields.created_by') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.onCall.fields.updated_by') }}
                        </th> --}}
                        <th>
                            Status
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                       $order = order(request()->page ?? 1, $onCalls->perPage())
                    @endphp
                    @foreach($onCalls as $key => $onCall)
                        <tr data-entry-id="{{ $onCall->id }}">
                            <td>
                                {{ $order++ }}     
                            </td>
                            <td>
                                {{ $onCall->created_at->format('M-d-Y') }}
                            </td>
                            <td>
                                {{ $onCall->project->name ?? 'No Project Name' }}
                            </td>
                            <td>
                                {{ $onCall->service_type->type ?? '' }}
                            </td>
                            <td>
                                {{ $onCall->customer->name ?? '' }}
                            </td>
                            <td>
                                {{ $onCall->created_by->name ?? '' }}
                            </td>
                            {{-- <td>
                                {{ $onCall->updated_by->name ?? '' }}
                            </td> --}}
                            <td>
                                {{ $statuses[$onCall->status] }}
                            </td>
                            <td>
                                @can('on_call_show')
                                    <a class="btn btn-sm btn-create px-2" href="{{ route('admin.on-calls.show', $onCall->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                {{-- @can('on_call_edit')
                                    <a class="btn btn-sm btn-info d-block my-1" href="{{ route('admin.on-calls.edit', $onCall->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('on_call_delete')
                                    <form action="{{ route('admin.on-calls.destroy', $onCall->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $onCalls->appends(array_filter(request()->except('page')))->links() }}
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('on_call_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.on-calls.massDestroy') }}",
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
  $('.datatable-OnCall:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection