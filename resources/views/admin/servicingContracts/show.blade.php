@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.servicingContract.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingContract.fields.project') }}
                        </th>
                        <td>
                            @if ($servicingContract->inhouse_installation)                                
                                <a href="{{ route('admin.sale-contracts.show', $servicingContract->inhouse_installation->sale_contract->id) }}">
                                    {{ $servicingContract->project ? $servicingContract->project->name : 'Go To Sales Contract' }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingContract.fields.interval') }}
                        </th>
                        <td>
                            {{ App\ServicingContract::INTERVAL_RADIO[$servicingContract->interval] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingContract.fields.contract_start_date') }}
                        </th>
                        <td>
                            {{ $servicingContract->contract_start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingContract.fields.contract_end_date') }}
                        </th>
                        <td>
                            {{ $servicingContract->contract_end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingContract.fields.remark') }}
                        </th>
                        <td>
                            {!! $servicingContract->remark !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingContract.fields.created_by') }}
                        </th>
                        <td>
                            {{ $servicingContract->created_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="card display-card my-2">
                <p class="font-weight-bold">Maintenances</p>
                <table class="en-list table table-borderless table-striped scrollbar">
                    <thead>
                        <tr>
                            <th>Estimated Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servicingContract->servicing_setups as $servicing_setup)                            
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($servicing_setup->estimated_date)->format('D, d-M-Y') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.servicing-setups.show', $servicing_setup->id) }}" 
                                    class="btn btn-sm btn-info rounded-pill"
                                    >
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-group mt-3">
                <a class="btn btn-create" href="{{ route('admin.servicing-contracts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection