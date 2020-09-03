@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.servicingSetup.title') }}
    </div>
    

    <div class="card-body">

        @if ($errors->any())            
            <div class="alert alert-danger my-2" role="alert">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)                        
                        <li class="list-item">{{ $error }}</li>                
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex my-3">
            <div>
                @if ($servicingSetup->request_type == "Oncall")
                    <a href="{{ route('admin.sale-contracts.allUploadedFiles', [$servicingSetup->onCall->sale_contract]) }}" class="btn btn-create">View Uploaded Files</a>
                @else
                    @if ($servicingSetup->morphable)          
                        <a href="{{ route('admin.sale-contracts.allUploadedFiles', [$servicingSetup->morphable->inhouse_installation->sale_contract]) }}" class="btn btn-create">View Uploaded Files</a>
                    @endif
                @endif
            </div>
        </div>

        <div class="form-group">

            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.project') }}
                        </th>
                        <td>
                            @if ($servicingSetup->request_type == "Oncall")
                                <a href="{{ route('admin.sale-contracts.show', $servicingSetup->onCall->sale_contract->id) }}">
                                    {{ $servicingSetup->project->name ?? 'Go To Sales Contract' }}
                                </a>
                            @else
                                @if ($servicingSetup->morphable)                                    
                                    <a href="{{ route('admin.sale-contracts.show', $servicingSetup->morphable->inhouse_installation->sale_contract->id) }}">
                                        {{ $servicingSetup->project->name ?? 'Go To Sales Contract' }}
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.is_major') }}
                        </th>
                        <td>
                            {{ App\ServicingSetup::IS_MAJOR_RADIO[$servicingSetup->is_major] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        {{-- <td>{{ $servicingSetup->status ? ucfirst($servicingSetup->status) :'' }}</td> --}}
                        <td>{{ $servicingSetup->status  }}</td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.estimated_date') }}
                        </th>
                        <td>
                            {{ $servicingSetup->estimated_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.actual_date') }}
                        </th>
                        <td>
                            {{ $servicingSetup->actual_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.request_type') }}
                        </th>
                        <td>
                            {{ $servicingSetup->request_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.service_report_pdf') }}
                        </th>
                        <td>
                            @if($servicingSetup->service_report_pdf)
                                <a href="{{ $servicingSetup->service_report_pdf }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.team_type') }}
                        </th>
                        <td>
                            {{ App\ServicingSetup::TEAM_TYPE_SELECT[$servicingSetup->team_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Assigned Teams
                        </th>
                        <td>
                            @foreach ($servicingSetup->servicingTeamConnectors as $connector)
                            <div>
                                @if ($connector->assigned_team )
                                <div class="d-flex">
                                    <div>
                                        Inhouse Team - {{$connector->assigned_team->leader_name ?? ''}} 
                                    </div>
                                    <div class="ml-auto">
                                        <a class="btn btn-sm btn-primary px-1 py-0" href="{{ route('admin.servicing-teams.show', $connector->assigned_team->id) }}">
                                            View
                                        </a>
                                        |
                                        <small>
                                            <form action="{{ route('admin.servicing-team-connectors.destroy', $connector->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" class="bg-transparent">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-sm btn-danger px-1 py-0">remove</button>
                                            </form>
                                        </small>
                                    </div>
                                </div>
                                @elseif ($connector->assigned_team)
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
                                            <form action="{{ route('admin.servicing-team-connectors.destroy', $connector->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" class="bg-transparent">
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
                            {{ trans('cruds.servicingSetup.fields.created_by') }}
                        </th>
                        <td>
                            {{ $servicingSetup->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingSetup.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $servicingSetup->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>            
        </div>

        <div class="card text-dark my-2">
            <nav>
                <div class="nav nav-tabs" id='nav-tab' role='tablist'>
                    <a href="#edit-servicing-setup" id="edit-servicing-setup-tab"
                        class="nav-item nav-link {{ $servicingSetup->getCurrentStage() == 'edit-servicing-setup' ? 'active' : '' }}
                                {{ in_array('edit-servicing-setup', $servicingSetup->getActiveStages()) ? '' : 'in-active-tab'}}" 
                        data-toggle="tab" 
                        role='tab'
                        aria-selected="{{ $servicingSetup->getCurrentStage() == 'edit-servicing-setup' }}">
                        Fill Estimate date
                    </a>
                    <a href="#actual-action" id="actual-action-tab"
                        class="nav-item nav-link {{ $servicingSetup->getCurrentStage() == 'actual-action' ? 'active' : '' }}
                            {{ in_array('actual-action', $servicingSetup->getActiveStages()) ? '' : 'in-active-tab'}}" 
                        data-toggle="tab" 
                        role='tab'
                        aria-selected="{{ $servicingSetup->getCurrentStage() == 'actual-action' }}">
                        Perform Actual action
                    </a>
                    <a href="#remark-tab-pane" id="remark-tab"
                        class="nav-item nav-link {{ $servicingSetup->getCurrentStage() == 'remark' ? 'active' : '' }}
                                {{ in_array('remark', $servicingSetup->getActiveStages()) ? '' : 'in-active-tab'}}" 
                        data-toggle="tab" 
                        role='tab'
                        aria-selected="{{ $servicingSetup->getCurrentStage() == 'remark' }}">
                        Remarks
                    </a>
                </div>
            </nav>

            <div class="tab-content" id="nav-tab-content">
                <div class="tab-pane fade show {{ $servicingSetup->getCurrentStage() == 'edit-servicing-setup' ? 'active' : '' }}"
                        id="edit-servicing-setup"
                        role="tabpanel"
                        aria-labelledby="session-tab">
                    <div class="card card-body">
                        @include('admin.servicingSetups.editForm')
                    </div>
                </div>
                <div class="tab-pane fade show {{ $servicingSetup->getCurrentStage() == 'actual-action' ? 'active' : '' }}"
                        id="actual-action"
                        role="tabpanel"
                        aria-labelledby="session-tab">
                    <div class="card card-body">
                        @include('admin.servicingSetups.actualActionForm')
                    </div>
                </div>
                <div class="tab-pane fade show {{ $servicingSetup->getCurrentStage() == 'remark' ? 'active' : '' }}"
                        id="remark-tab-pane"
                        role="tabpanel"
                        aria-labelledby="session-tab">
                    <div class="card card-body">

                        @if ($servicingSetup->servicingSetupRemarks)                            
                            @include('admin.servicingSetups.showRemarks', ['servicingSetupRemarks' => $servicingSetup->servicingSetupRemarks])
                        @endif

                        @if($servicingSetup->actual_date)
                            <div class="card">
                                <h5 class="card-header">Add More Remarks</h5>
                                <div class="card-body">
                                    <form action='{{ route('admin.servicing-setups-remarks.store', [$servicingSetup]) }}' method="POST">
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

        <div class="py-3">
            <a class="btn btn-create" href="{{ route('admin.servicing-setups.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>

@endsection

@section('scripts')
    <script>
        function perform() {
            alert('working')
        }
        let customBtn = document.getElementById('actual-action-servicing-setup')

        function loadPerformActionSpinner() {
            // customBtn.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>';
            alert('its work')
        }
    </script>
@endsection