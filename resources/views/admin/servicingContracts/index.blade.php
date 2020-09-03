@extends('layouts.admin')
@section('content')
@can('servicing_contract_create')
    <div style="margin-left: 30px;" class="my-3">
        <a class="btn btn-create" href="{{ route("admin.in-house-installations.index") }}">
            {{ trans('global.add') }} {{ trans('cruds.servicingContract.title_singular') }}
        </a>

    </div>
@endcan
<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('cruds.servicingContract.title') }} {{ trans('global.list') }}
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
                            {{ trans('cruds.servicingContract.fields.project') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.interval') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.contract_start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.contract_end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.updated_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $servicingContracts->perPage())
                    @endphp
                    @foreach($servicingContracts as $key => $servicingContract)
                        <tr data-entry-id="{{ $servicingContract->id }}">
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                {{ $servicingContract->created_at->format('M-d-Y') }}
                            </td>
                            <td>
                                {{ $servicingContract->project->name ?? '' }}
                            </td>
                            <td>
                                {{ App\ServicingContract::INTERVAL_RADIO[$servicingContract->interval] ?? '' }}
                            </td>
                            <td>
                                {{ $servicingContract->contract_start_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingContract->contract_end_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingContract->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $servicingContract->updated_by->name ?? '' }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    @can('servicing_contract_show')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.servicing-contracts.show', $servicingContract->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
    
                                    {{-- @can('servicing_contract_edit')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.servicing-contracts.edit', $servicingContract->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan --}}
    
                                    {{-- @can('servicing_contract_delete')
                                        <form action="{{ route('admin.servicing-contracts.destroy', $servicingContract->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-sm btn-create text-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan --}}
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="my-2">
                {{ $servicingContracts->links() }}
            </div>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>


</script>
@endsection