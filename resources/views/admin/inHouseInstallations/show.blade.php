@extends('layouts.admin')
@section('content')

@include('showErrors')
@include('instruction')
<div class="card content-card display-card text-white">
    <div class="card-header d-flex">
        <div>
            {{ trans('cruds.inHouseInstallation.title') }} Details
        </div>
        <div class="ml-auto">
            <a href="{{ route('admin.sale-contracts.show', $saleContract) }}" class="btn btn-sm btn-create">Go To Sales Contract</a>
        </div>
    </div>

    <div class="card-body">

        <div class="form-group">
            @if($inHouseInstallation->sale_contract->projectCompleted() && !$inHouseInstallation->isProjectApproved())
            @can('sale_contract_approve_access')                
            <div class='form-group'>
                <form action="{{ route('admin.sale-contracts.inhouseInstallation.approve-project', [$inHouseInstallation->sale_contract, $inHouseInstallation]) }}" method="POST" onsubmit="return confirm('Sure to approve!');">
                    @csrf
                    <label>Project Approval Required!</label>
                    <button type="submit" class="btn" style="text-decoration: underline;color: red;">Approve this project.</button>
                </form>
            </div>
            @endcan
            @endif
            {{-- approved_service_manager_id
                approved_project_manager_id --}}
            @if ($inHouseInstallation->approved_service_manager_id || $inHouseInstallation->approved_project_manager_id)
                <div class="alert alert-primary w-75 py-1" role="alert">
                    <ul class="list-unstyled my-2">
                        @if ($inHouseInstallation->approved_service_manager_id && !$inHouseInstallation->approved_project_manager_id)
                            <li class="list-item text-success mb-1">
                                <i class="fas fa-check-circle"></i> 
                                Approved by Service Manager: {{ $inHouseInstallation->approved_service_manager->name ?? '' }}
                            </li>
                            <li class="list-item text-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                Pending Approval for Project Manager
                            </li>
                        @endif

                        @if (!$inHouseInstallation->approved_service_manager_id && $inHouseInstallation->approved_project_manager_id)
                            <li class="list-item text-success mb-1">
                                <i class="fas fa-check-circle"></i> 
                                Approved by Project Manager: {{ $inHouseInstallation->approved_project_manager->name ?? '' }}
                            </li>
                            <li class="list-item text-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                Pending Approval for Service Manager
                            </li>                            
                        @endif

                        @if ($inHouseInstallation->approved_service_manager_id && $inHouseInstallation->approved_project_manager_id)
                            <li class="list-item text-success">
                                <i class="fas fa-check-circle"></i> 
                                Approved by Project Manager: {{ $inHouseInstallation->approved_project_manager->name ?? '' }}
                            </li>
                            <li class="list-item text-success mb-1">
                                <i class="fas fa-check-circle"></i> 
                                Approved by Service Manager: {{ $inHouseInstallation->approved_service_manager->name ?? '' }}
                            </li>
                        @endif
                    </ul>
                </div>
            @elseif(!$inHouseInstallation->approved_service_manager_id && !$inHouseInstallation->approved_project_manager_id)                <div class="alert alert-primary w-75 py-1" role="alert">
                    <ul class="list-unstyled my-2">
                        <li class="list-item text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            Pending Approval for Project Manager
                        </li>
                        <li class="list-item text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            Pending Approval for Service Manager
                        </li>
                    </ul>
                </div>
            @endif            

            @include('admin.saleContracts.infoTable', ['saleContract' => $inHouseInstallation->sale_contract])
            
            <div class="d-flex my-3">
                <p class="font-weight-bold m-0 pt-2">In-house Teams</p>
                <div>                    
                    <a href="{{ route('admin.in-house-installations.edit', $inHouseInstallation) }}" 
                    class="btn btn-create btn-sm ml-5"><i class="fas fa-edit"></i> Edit</a>
                </div>
            </div>

            {{-- @include('admin.inHouseInstallations.info') --}}
            @include('admin.saleContracts.inhouseTeams')

            {{-- @can('upload_other_docs_create')
            <div class="form-group">
                <a href="{{ route("admin.sale-contracts.in-house-installation.docs.index", [$inHouseInstallation->sale_contract, $inHouseInstallation]) }}" class="btn btn-create">
                    View Docs
                </a>
            </div>
            @endcan --}}

            @include('admin.inHouseInstallations.documentDetails')

            @include('admin.inHouseInstallations.servicings', ['inHouseInstallations' => $inHouseInstallation])                
            
            @include('admin.saleContracts.installationTeams', ['saleContract' => $inHouseInstallation->sale_contract])
            
            @include('admin.saleContracts.installationProgress', ['saleContract' => $inHouseInstallation->sale_contract])

            @include('admin.saleContracts.materialDeliveryProgress', ['saleContract' => $inHouseInstallation->sale_contract])

            <div class="form-group my-3">
                <a class="btn btn-create" href="{{ route('admin.in-house-installations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>

        

    </div>

    
</div>
@endsection

@section('scripts')
    <script>
        let storeMaterialDelivery = document.getElementById('material-delivery-progressing-upload')

        function loadSpinner() {
            storeMaterialDelivery.innerHTML = 'Updating <i class="fas fa-spinner fa-spin"></i>';
        }
        
    </script>
@endsection