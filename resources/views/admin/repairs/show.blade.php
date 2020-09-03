@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.repair.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">            
            
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            Project Name
                        </th>
                        <td>
                            @if ($repair->oncall->sale_contract)
                                <a href="{{ route('admin.sale-contracts.show', $repair->oncall->sale_contract) }}">
                                    {{ $repair->oncall->project ? $repair->oncall->project->name : 'Go To Sales Contract' }}
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            @endif                            
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.estimate_date') }}
                        </th>
                        <td>
                            {{ $repair->estimate_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.repair.fields.status') }}</th>
                        <td>{{ $repair->status ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.actual_date') }}
                        </th>
                        <td>
                            {{ $repair->actual_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Assigned Teams
                        </th>
                        <td>
                            @foreach ($repair->repairTeamConnectors as $connector)                            
                                <div>
                                    @if ($connector->assigned_team->leader_name )
                                    <div class="d-flex">
                                        <div>
                                            Inhouse Team - {{$connector->assigned_team->leader_name ?? ''}} 
                                        </div>
                                        <div class="ml-auto">
                                            <a class="btn btn-sm btn-primary px-1 py-0" href="{{ route('admin.repair-teams.show', $connector->assigned_team->id) }}">
                                                View
                                            </a>
                                            |
                                            <small>
                                                <form action="{{ route('admin.repair-team-connectors.destroy', $connector->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" class="bg-transparent">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-sm btn-danger px-1 py-0">remove</button>
                                                </form>
                                            </small>
                                        </div>
                                    </div>
                                    @elseif ($connector->assigned_team->company_name)
                                    <div class="d-flex">
                                        <div>
                                            Sub Company - {{$connector->assigned_team->company_name ?? ''}}
                                        </div>
                                        <div class="ml-auto">
                                            <a class="btn btn-sm btn-primary px-1 py-0" href="{{ route('admin.sub-companies.show', $connector->assigned_team->id) }}">
                                                View
                                            </a>
                                            |
                                            <small>
                                                <form action="{{ route('admin.repair-team-connectors.destroy', $connector->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" class="bg-transparent">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-sm btn-danger px-1 py-0">remove</button>
                                                </form>
                                            </small>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.has_spare_part_replacement') }}
                        </th>
                        <td>
                            {{ App\Repair::HAS_SPARE_PART_REPLACEMENT_RADIO[$repair->has_spare_part_replacement] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.service_report_pdf') }}
                        </th>
                        <td>
                            @if ( $repair->service_report_pdf )
                                <a href="{{ $repair->service_report_pdf }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.created_by') }}
                        </th>
                        <td>
                            {{ $repair->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $repair->updated_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.team_type') }}
                        </th>
                        <td>
                            {{ App\Repair::TEAM_TYPE_SELECT[$repair->team_type] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="card text-dark">
                <nav>
                    <div class="nav nav-tabs" id='nav-tab' role='tablist'>
                        <a href="#edit-repair" id="edit-repair-tab"
                            class="nav-item nav-link {{ $repair->getCurrentStage() == 'edit-repair' ? 'active' : '' }}
                                    {{ in_array('edit-repair', $repair->getActiveStages()) ? '' : 'in-active-tab'}}" 
                            data-toggle="tab" 
                            role='tab'
                            aria-selected="{{ $repair->getCurrentStage() == 'edit-repair' }}">
                            Fill Estimate date
                        </a>
                        <a href="#actual-action" id="actual-action-tab"
                            class="nav-item nav-link {{ $repair->getCurrentStage() == 'actual-action' ? 'active' : '' }}
                                {{ in_array('actual-action', $repair->getActiveStages()) ? '' : 'in-active-tab'}}" 
                            data-toggle="tab" 
                            role='tab'
                            aria-selected="{{ $repair->getCurrentStage() == 'actual-action' }}">
                            Perform Actual action
                        </a>
                        <a href="#remark-tab-pane" id="remark-tab"
                            class="nav-item nav-link {{ $repair->getCurrentStage() == 'remark' ? 'active' : '' }}
                                    {{ in_array('remark', $repair->getActiveStages()) ? '' : 'in-active-tab'}}" 
                            data-toggle="tab" 
                            role='tab'
                            aria-selected="{{ $repair->getCurrentStage() == 'remark' }}">
                            Remarks
                        </a>
                    </div>
                </nav>
    
                <div class="tab-content" id="nav-tab-content">
                    <div class="tab-pane fade show {{ $repair->getCurrentStage() == 'edit-repair' ? 'active' : '' }}"
                            id="edit-repair"
                            role="tabpanel"
                            aria-labelledby="session-tab">
                        <div class="card card-body">
                            @include('admin.repairs.editForm')
                        </div>
                    </div>
                    <div class="tab-pane fade show {{ $repair->getCurrentStage() == 'actual-action' ? 'active' : '' }}"
                            id="actual-action"
                            role="tabpanel"
                            aria-labelledby="session-tab">
                        <div class="card card-body">
                            @include('admin.repairs.actualActionForm')
                        </div>
                    </div>
                    <div class="tab-pane fade show {{ $repair->getCurrentStage() == 'remark' ? 'active' : '' }}"
                            id="remark-tab-pane"
                            role="tabpanel"
                            aria-labelledby="session-tab">
                        <div class="card card-body">
                            @include('admin.repairRemarks.index')
                            @if($repair->actual_date)
                                <div class="card">
                                    <h5 class="card-header">Add More Remarks</h5>
                                    <div class="card-body">
                                        <form action='{{ route('admin.repairs.remarks.create', [$repair]) }}' method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="remark">{{ trans('cruds.onCall.fields.remark') }}</label>
                                                    <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
                                                    @if($errors->has('remark'))
                                                        <span class="text-danger">{{ $errors->first('remark') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.onCall.fields.remark_helper') }}</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-save" type="submit">
                                                {{ trans('global.save') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <a class="btn btn-create" href="{{ route('admin.repairs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection

@section('scripts')
    <script>
        let storeRepairActualAction = document.getElementById('repair-actual-action-store')

        function loadSpinner() {
            if ( storeRepairActualAction.innerHTML == 'Save') {
                storeRepairActualAction.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>';
            } else if (storeRepairActualAction.innerHTML == 'Update') {
                storeRepairActualAction.innerHTML = 'Updating <i class="fas fa-spinner fa-spin"></i>';
            }
        }
    </script>
@endsection