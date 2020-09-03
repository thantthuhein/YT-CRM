@extends('layouts.admin')

@section('content')

@can('enquiry_access')
<div class="header-card">
    
    <form action="{{ route("admin.enquiries.index") }}" method="GET" name="filter" id="pagination-form">

        <div class="header-first">

            <div class="enquiry-pagination">
                <label class="label-text">Show:</label>
                    <select name="take" onchange="document.forms['filter'].submit()">
                        @foreach(config('paginate.pagination') as $value)
                        <option {{$value == request()->take ? "selected" : ""}}>{{$value}}</option>
                        @endforeach
                    </select>
            </div>

            <div class="type_filter">
                <label class="label-text">Type:</label>
                <form action="{{ route("admin.enquiries.index") }}" method="GET" id="type_select">

                    <select name="type" onchange="document.forms['filter'].submit()">
                        @foreach($typeOfSales as $key => $type)
                            <option value="{{ $key }}" {{$key == request()->type ? "selected":""}}>{{$type}}</option>
                        @endforeach
                    </select>
            </div>
            
            <div class="type_filter">
                <label class="label-text">Status:</label>

                    <select name="status" onchange="document.forms['filter'].submit()">
                        <option value="">Please Select</option>
                        @foreach(App\Enquiry::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ request()->status === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
            </div>

            <div class="type_filter">
                <label class="label-text">Aircon:</label>

                    <select name="aircon_type" onchange="document.forms['filter'].submit()">
                        <option value="">Please Select</option>
                        @foreach($airconTypes as $key => $label)
                            <option value="{{ $key }}" {{ request()->aircon_type === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
            </div>

            <div class="enqyiry-search">
                <i class="fa fa-search white-color" aria-hidden="true"></i>
                <input type="text" name="q" id="enquiry" onblur="document.forms['filter'].submit()" value="{{ request()->q }}" style="color: white;width:auto;"/>
            </div>

        </div>
    </form>

    @can('enquiry_create')
        <div style="margin-bottom: 10px;" class="header-second">
            <div class="col-lg-12">
                <a class="btn btn-create mr-3" href="{{ route("admin.enquiries.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.enquiry.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
</div>

<div class="card content-card display-card">
    <div class="card-header enquiry-create text-white">
        Sales {{ trans('cruds.enquiry.title') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            
            <table class="en-list table table-borderless table-striped">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th width="10">
                            Actions
                        </th>
                        <th>
                            Created At
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.enquiries_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.type_of_sales') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.project') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.location') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.has_installation') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.has_future_action') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.enquiry.fields.receiver_name') }}
                        </th>
                        <th>
                            Has Quotation
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                       $order = order(request()->page ?? 1, $enquiries->perPage())
                    @endphp
                    @foreach($enquiries as $key => $enquiry)
                        <tr data-entry-id="{{ $enquiry->id }}">
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                <div class="actions-wrapper">

                                    @if ( ! $enquiry->quotations->isEmpty() )
                                        <div>
                                            <a style="width:150px;" class="btn btn-create btn-sm"  
                                            href="{{ route('admin.quotations.show', optional($enquiry->quotations->first())->id )}}"
                                            >
                                                {{trans('cruds.quotation.fields.view_quotation')}}
                                            </a>
                                            <a style="width:150px;" class="btn btn-create btn-sm disabled mt-2" 
                                            href="#">
                                                Create Sales Contract
                                            </a>
                                        </div>
                                    @elseif ( $enquiry->quotations->isEmpty() && $enquiry->saleContract !== NULL )
                                        <div>
                                            <a style="width:150px;" class="btn btn-create btn-sm disabled" href="#">
                                                {{ trans('global.create_quotation') }}
                                            </a>
                                            <a style="width:150px;" class="btn btn-create btn-sm mt-2" href="{{ route('admin.sale-contracts.show', $enquiry->saleContract->id ) }}">
                                                {{trans('cruds.saleContract.fields.view_sale_contract')}}
                                            </a>
                                        </div>    
                                    @else
                                        <div>
                                            <a style="width:150px;" class="btn btn-sm btn-create" href="quotations/create?enquiry_id={{$enquiry->id}}">
                                                {{ trans('global.create_quotation') }}
                                            </a>
                                            <a style="width:150px;" class="btn btn-create btn-sm mt-2" href="{{ route('admin.enquiries.sale-contracts.create', ['enquiry' => $enquiry->id]) }}">
                                                Create Sales Contract
                                            </a>
                                        </div> 
                                    @endif



                                    {{-- <div>
                                        <a class="btn btn-sm btn-create" href="quotations/create?enquiry_id={{$enquiry->id}}">
                                            {{ trans('global.create_quotation') }}
                                        </a>
                                    </div>  
                                    <div>
                                        <a class="btn btn-create btn-sm" 
                                        href="{{ route('admin.quotations.show', optional($enquiry->quotations->first())->id )}}">
                                            {{trans('cruds.quotation.fields.view_quotation')}}
                                        </a>
                                    </div>

                                    <div>
                                        <a class="btn btn-create btn-sm" href="{{ route('admin.enquiries.sale-contracts.create', ['enquiry' => $enquiry->id]) }}">
                                            Create Sale Contract
                                        </a>
                                    </div>
                                    <div>
                                        <a class="btn btn-create btn-sm" href="{{ route('admin.sale-contracts.show', $enquiry->saleContract->id ) }}">
                                            {{trans('cruds.saleContract.fields.view_sale_contract')}}
                                        </a>
                                    </div> --}}
    
                                </div>
                            </td>
                            <td>
                                {{ $enquiry->created_at->format('M-d-Y') ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->enquiries_type->type ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->type_of_sales->type ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->customer->name ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->company->name ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->project->name ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->location ?? '' }}
                            </td>
                            <td>
                                {{ App\Enquiry::HAS_INSTALLATION_SELECT[$enquiry->has_installation] ?? '' }}
                            </td>
                            <td>
                                {{ App\Enquiry::HAS_FUTURE_ACTION_SELECT[$enquiry->has_future_action] ?? '' }}
                            </td>
                            <td>
                                {{ App\Enquiry::STATUS_SELECT[$enquiry->status] ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $enquiry->receiver_name ?? '' }}
                            </td>
                            <td>
                                @if ($enquiry->quotations->isEmpty())
                                    No
                                @else
                                    Yes
                                @endif
                                {{-- {{$enquiry->quotations}} --}}
                            </td>
                            <td>
                                <div class="d-flex">
                                    @can('enquiry_show')
                                        <div class="mr-1">
                                            <a class="btn btn-sm btn-create" href="{{ route('admin.enquiries.show', $enquiry->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        </div>
                                    @endcan
    
                                    @can('enquiry_edit')
                                        <div class='mr-1'>
                                            <a class="btn btn-sm btn-create" href="{{ route('admin.enquiries.edit', ['enquiry'=> $enquiry->id, 'page' => request()->page ?? 1]) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        </div>
                                    @endcan
                                    
                                    @can('enquiry_delete')
                                        @if(!($enquiry->quotations->count() > 0 || $enquiry->saleContract))
                                            @if ($enquiry->isExistedToday(optional($enquiry->customer)->id))                                                
                                                <div class='mr-1'>
                                                    <form action="{{ route('admin.enquiries.destroy', $enquiry->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-sm btn-create text-danger" value="{{ trans('global.delete') }}">
                                                    </form>
                                                </div>
                                            @endif 
                                        @endif
                                    @endcan
    
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $enquiries->appends(array_filter(request()->except('page')))->links() }}
        </div>

    </div>
</div>
@endcan
@endsection

@section('scripts')

@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('enquiry_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.enquiries.massDestroy') }}",
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
  $('.datatable-Enquiry:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

let enquiry = document.querySelector("#enquiry");
    const debounce = {
        debounce (func, wait, immediate) {
            console.log("Hello de")
            let timeout;
            return function() {
                let context = this, args = arguments;
                let later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                let callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }
    }

//     enquiry.addEventListener('keyup',debounce.debounce((event) => enquirysearch(event),500));

//     function enquirysearch(event){
//         document.getElementById('search').submit();

//         // search_text=event.target.value;
//         // console.log(search_text);
//         //     fetch(`/api/v1/searchEnquiry?search_text=${search_text}`,{
//         //         method: "Get",
//         //         headers: {
//         //             "Content-Type": "application/json",
//         //             "Accept": "application/json",
//         //         },
//         //     })
//         //     .then(res => (res.json()))
//         //     .then(data=>{
//         //         console.log("enquiry data is",data);
         
        //     })
    // }
</script>
@endsection