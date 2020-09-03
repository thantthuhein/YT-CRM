@extends('layouts.admin')
@section('content')

@php
$progress = optional(optional($saleContract->inHouseInstallation)->installationProgresses)->last()->progress ?? 0;
@endphp

<div>
    @if(session('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{session('success')}}</li>
            </ul>
        </div>
    @endif
</div>

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.saleContract.title') }}
    </div>

    <div class="card-body">
        
        <div class="form-group">
            <div class="sale-contract-action-list">
                {{-- @can('payment_steps_create')
                @endcan --}}
                <div class="sale-contract-action {{ $saleContract->payment_status == 'Complete' ? 'disabled' : '' }}">
                    <a class="btn btn-create" href="{{ route('admin.sale-contracts.make-payment', [$saleContract]) }}">
                        Make Payment
                    </a>
                </div>
                @if($saleContract->has_installation)
                    @if($saleContract->installation_type == 'inhouse')
                        @if(!$saleContract->inHouseInstallation)
                            <div class="sale-contract-action">
                                <a class="btn btn-create" href="{{ route("admin.in-house-installations.create", ["sale-contract-id" => $saleContract]) }}">
                                    Assign In-house Teams
                                </a>
                            </div>  
                        @endif
                    @elseif($saleContract->installation_type == 'subcom')
                        <div class="sale-contract-action">
                            <a class="btn btn-create" href="{{ route('admin.sale-contracts.assign-subcom-teams', [$saleContract]) }}">
                                Assign Sub-con Teams
                            </a>
                        </div>
                    @else
                        <div class="sale-contract-action">
                            <a class="btn btn-create" href="{{ route('admin.sale-contracts.assign-subcom-teams', [$saleContract]) }}">
                                Assign Sub-con Teams
                            </a>
                        </div>

                        @if(!$saleContract->inHouseInstallation)
                            <div class="sale-contract-action">
                                <a class="btn btn-create" href="{{ route("admin.in-house-installations.create", ["sale-contract-id" => $saleContract]) }}">
                                    Assign In-house Teams
                                </a>
                            </div>  
                        @endif

                    @endif
                @endif

                {{-- @if($saleContract->inHouseInstallation && $saleContract->projectCompleted())
                    <div class="sale-contract-action">
                        <a class="btn btn-success" href="{{ route('admin.sale-contracts.inhouseInstallation.addCompletedData', [$saleContract, $saleContract->inHouseInstallation]) }}">
                            Add Completed Data
                        </a>
                    </div>
                @endif --}}
                @if(optional($saleContract)->inHouseInstallation)
                    <div class="sale-contract-action">
                        <a class="btn btn-create" href="{{ route('admin.in-house-installations.show', [$saleContract->inHouseInstallation]) }}">
                            View Inhouse Installation
                        </a>
                    </div>
                @endif                
  
            </div>
            
            @include('admin.saleContracts.infoTable')

            <div class="card my-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item p-0">
                        <a class="nav-link active" id="equipment-deliery-schedule-tab" data-toggle="tab" href="#equipment-deliery-schedule" role="tab" aria-controls="equipment-deliery-schedule" aria-selected="true">Equipment Delivery Schedule</a>
                    </li>

                    <li class="nav-item p-0">
                        <a class="nav-link" id="document-pdf-tab" data-toggle="tab" href="#document-pdf" role="tab" aria-controls="document-pdf" aria-selected="true">Sales Contract Document</a>
                    </li>

                    <li class="nav-item p-0">
                        <a class="nav-link" id="docs-for-sm-tab" data-toggle="tab" href="#docs-for-sm" role="tab" aria-controls="docs-for-sm" aria-selected="true">Documents For Service Manager</a>
                    </li>
                </ul>
                <div class="tab-content text-dark" id="myTabContent">
                    <div class="tab-pane fade show active" id="equipment-deliery-schedule" role="tabpanel" aria-labelledby="equipment-deliery-schedule-tab">
                        @include('admin.saleContracts.equipmentDeliverySchedules')
                    </div>

                    <div class="tab-pane fade" id="document-pdf" role="tabpanel" aria-labelledby="document-pdf-tab">                        
                        @include('admin.saleContracts.documentPdfs')
                    </div>

                    <div class="tab-pane fade" id="docs-for-sm" role="tabpanel" aria-labelledby="docs-for-sm-tab">
                        @include('admin.saleContracts.docsForServiceManager')
                    </div>
                </div>
            </div>            

            {{-- <a href="{{ route('admin.sale-contracts.allUploadedFiles', [$saleContract]) }}" class="btn btn-create" >View All Uploaded Files</a> --}}

            @include('admin.saleContracts.teamTabs')
            
            {{-- @if($saleContract->inHouseInstallation)
                @include('admin.saleContracts.installationTeams')

                @include('admin.saleContracts.installationProgress', ['saleContract' => $saleContract])

                @include('admin.saleContracts.materialDeliveryProgress', ['saleContract' => $saleContract])
            @endif --}}

            <div class="form-group">
                <a class="btn btn-create" href="{{ route('admin.sale-contracts.index') }}">
                    <i class="fas fa-long-arrow-alt-left"></i> {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
<script>
    function submitApproveForm(){
        document.approveForm.submit();
    }
</script>
@endsection