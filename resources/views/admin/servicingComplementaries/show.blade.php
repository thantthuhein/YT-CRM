@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.servicingComplementary.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.inhouse_installation') }}
                        </th>
                        <td>
                            <a href="{{ route('admin.in-house-installations.show', $servicingComplementary->inhouse_installation) }}">
                                {{ $servicingComplementary->inhouse_installation->estimate_start_date ?? '' }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.project') }}
                        </th>
                        <td>
                            <a href="{{ route('admin.sale-contracts.show', $servicingComplementary->inhouse_installation->sale_contract->id) }}">
                                {{ $servicingComplementary->project ? $servicingComplementary->project->name : 'Go To Sales Contract' }}
                            </a>
                        </td>
                    </tr>                
                    <tr>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.created_by') }}
                        </th>
                        <td>
                            {{ $servicingComplementary->created_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="card display-card my-2">
                <p class="font-weight-bold">Maintenances</p>
                <table class="en-list table table-borderless table-striped scrollbar">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servicingComplementary->servicing_setups as $servicing_setup)                            
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($servicing_setup->estimated_date)->format('D, d-M-Y') }}</td>
                            <td>
                                <a href="{{ route('admin.servicing-setups.show', $servicing_setup->id) }}" 
                                class="btn btn-sm btn-info rounded-pill"><i class="fas fa-eye"></i> View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <a class="btn btn-create" href="{{ route('admin.servicing-complementaries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection