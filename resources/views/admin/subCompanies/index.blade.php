@extends('layouts.admin')
@section('content')
@can('sub_company_create')
    <div style="margin-left: 30px;" class="my-3">
        <a class="btn btn-create" href="{{ route("admin.sub-companies.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.subCompany.title_singular') }}
        </a>
    </div>
@endcan
<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('cruds.subCompany.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.subCompany.fields.company_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.subCompany.fields.contact_person_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.subCompany.fields.contact_person_phone_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.subCompany.fields.is_active') }}
                        </th>
                        <th>
                            {{ trans('cruds.subCompany.fields.rating') }}
                        </th>
                        <th>
                            {{ trans('cruds.subCompany.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.subCompany.fields.updated_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $subCompanies->perPage())
                    @endphp
                    @foreach($subCompanies as $key => $subCompany)
                        <tr>
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                {{ $subCompany->company_name ?? '' }}
                            </td>
                            <td>
                                {{ $subCompany->contact_person_name ?? '' }}
                            </td>
                            <td>
                                {{ $subCompany->contact_person_phone_number ?? '' }}
                            </td>
                            <td>
                                {{ App\SubCompany::IS_ACTIVE_RADIO[$subCompany->is_active] ?? '' }}
                            </td>
                            <td>
                                {{ $subCompany->overall_ratings ?? '' }} / 5
                            </td>
                            <td>
                                {{ $subCompany->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $subCompany->updated_by->name ?? '' }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    @can('sub_company_show')
                                        <a class="btn btn-sm btn-create px-2 mr-2" href="{{ route('admin.sub-companies.show', $subCompany->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
    
                                    @can('sub_company_edit')
                                        <a class="btn btn-sm btn-create px-2 mr-2" href="{{ route('admin.sub-companies.edit', $subCompany->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
    
                                    @can('sub_company_delete')
                                        <form action="{{ route('admin.sub-companies.destroy', $subCompany->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-sm btn-create px-2 text-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </div>
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
@can('sub_company_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sub-companies.massDestroy') }}",
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
  $('.datatable-SubCompany:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection