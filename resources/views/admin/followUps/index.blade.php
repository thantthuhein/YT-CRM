@extends('layouts.admin')
@section('content')
@can('follow_up_create')
    <div style="margin: 10px 30px;" class="row">
        <div class="col-lg-12 p-0">
            <a class="btn btn-success" href="{{ route("admin.follow-ups.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.followUp.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card content-card">
    <div class="card-header">
        {{ trans('cruds.followUp.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-FollowUp">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.followUp.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.followUp.fields.quotation_revision') }}
                        </th>
                        <th>
                            {{ trans('cruds.followUp.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.followUp.fields.follow_up_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.followUp.fields.contact_person') }}
                        </th>
                        <th>
                            {{ trans('cruds.followUp.fields.contact_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.followUp.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($followUps as $key => $followUp)
                        <tr data-entry-id="{{ $followUp->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $followUp->id ?? '' }}
                            </td>
                            <td>
                                {{ $followUp->quotation_revision->quotation_revision ?? '' }}
                            </td>
                            <td>
                                {{ $followUp->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $followUp->follow_up_time ?? '' }}
                            </td>
                            <td>
                                {{ $followUp->contact_person ?? '' }}
                            </td>
                            <td>
                                {{ $followUp->contact_number ?? '' }}
                            </td>
                            <td>
                                {{ $followUp->quotation_revision->status ?? '' }}
                            </td>
                            <td>
                                @can('follow_up_show')
                                    <a class="btn btn-sm btn-primary d-block my-1" href="{{ route('admin.follow-ups.show', $followUp->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('follow_up_edit')
                                    <a class="btn btn-sm btn-info d-block my-1" href="{{ route('admin.follow-ups.edit', $followUp->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('follow_up_delete')
                                    <form action="{{ route('admin.follow-ups.destroy', $followUp->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('follow_up_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.follow-ups.massDestroy') }}",
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
  $('.datatable-FollowUp:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection