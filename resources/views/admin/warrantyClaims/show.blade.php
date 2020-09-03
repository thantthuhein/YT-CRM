@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.warrantyClaim.title') }}
    </div>

    <div class="card-body">        

        <div class="form-group">

            @if($warrantyClaim->status == 'rejected')
                <div class="sale-contract-action alert alert-danger">
                    This warranty has been REJECTED by {{ optional($warrantyClaim->updated_by)->name}}!
                </div>
            @endif

            <div class="sale-contract-action-list">
                @if($warrantyClaim->showAcceptReject())
                    <div class="sale-contract-action {{ $warrantyClaim->status == 'accepted' ? 'in-active-tab' : '' }} ">
                        <form method="POST" action="{{ route("admin.warranty-claims.update", [$warrantyClaim]) }}" onsubmit="return confirm('Sure to approve this warranty?');">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="btn btn-success rounded-pill">
                                Approve
                            </button>
                        </form>
                    </div> 
                    
                    <div class="sale-contract-action {{ $warrantyClaim->status == 'rejected' ? 'in-active-tab' : '' }} ">
                        <form method="POST" action="{{ route("admin.warranty-claims.update", [$warrantyClaim]) }}" onsubmit="return confirm('Sure to reject this warranty?');">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger rounded-pill">
                                Reject
                            </button>
                        </form>
                    </div> 
                @endif
            </div>

            <div class="form-group">
                <a href="{{ route('admin.sale-contracts.allUploadedFiles', [$warrantyClaim->oncall->sale_contract]) }}" class="btn btn-create" >
                    View Related Information
                </a>
            </div>
            
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            Project
                        </th>
                        <td>
                            <a 
                            href="{{ route('admin.sale-contracts.show', optional($warrantyClaim->oncall)->sale_contract->id ) }}">
                                {{ $warrantyClaim->oncall->project->name ?? 'Go To Sales Contract' }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaim.fields.warranty_claim_validation') }}
                        </th>
                        <td>
                            Team - {{ $warrantyClaim->warranty_claim_validation->repair_team->leader_name ?? "" }}<br>
                            Date - {{ $warrantyClaim->warranty_claim_validation->actual_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaim.fields.warranty_claim_action') }}
                        </th>
                        <td>
                            Team - {{ $warrantyClaim->warranty_claim_action->repairTeam->leader_name ?? "" }}<br>
                            Date - {{ $warrantyClaim->warranty_claim_action->actual_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaim.fields.warranty_claim_pdf') }}
                        </th>
                        <td>
                            @if($warrantyClaim->warranty_claim_pdf)
                                <a href="{{ $warrantyClaim->warranty_claim_pdf }}" target="_blank" class="btn btn-sm btn-info rounded-pill">
                                    <i class="fas fa-eye"></i> View PDF
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaim.fields.status') }}
                        </th>
                        <td>
                            {{ App\WarrantyClaim::STATUS_SELECT[$warrantyClaim->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            In House Installation
                        </th>
                        <td>
                            @if ($warrantyClaim->oncall->sale_contract->inhouseInstallation)                                
                                <a href="{{ route('admin.in-house-installations.show', $warrantyClaim->oncall->sale_contract->inhouseInstallation) }}">View</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            T & C Date
                        </th>
                        <td>
                            {{ $warrantyClaim->oncall->sale_contract->inhouseInstallation->tc_time ?? 'TC Date Not Uploaded yet' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Installation Date
                        </th>
                        <td>
                            <span>from: {{ $warrantyClaim->oncall->sale_contract->inhouseInstallation->actual_start_date ?? '' }}</span><br>
                            <span>to: {{ $warrantyClaim->oncall->sale_contract->inhouseInstallation->actual_end_date ?? '' }}</span>
                        </td>
                    </tr>                    
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaim.fields.created_by') }}
                        </th>
                        <td>
                            {{ $warrantyClaim->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaim.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $warrantyClaim->updated_by->name ?? '' }}
                        </td>
                    </tr>                    
                </tbody>
            </table>

            <div class="card my-3">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link {{ $warrantyClaim->getCurrentStage() == 'status' ? 'active' : "" }} {{ in_array('status', $currentStages) ? "" : "in-active-tab" }}" 
                            id="status-tab" 
                            data-toggle="tab" href="#status" 
                            role="tab" aria-selected="{{ $warrantyClaim->getCurrentStage() == 'status' }}">
                            Status {{$warrantyClaim->getCurrentStage()}}
                        </a>
                        <a class="nav-item nav-link {{ $warrantyClaim->getCurrentStage() == 'pdf_upload' ? 'active' : "" }} {{ in_array('pdf_upload', $currentStages) ? '' : 'in-active-tab' }}" 
                            id="pdf-tab" 
                            data-toggle="tab" href="#pdf_upload" role="tab" 
                            aria-selected="{{ $warrantyClaim->getCurrentStage() == 'pdf_upload' }}">
                            Upload Claim PDF
                        </a>
                        <a class="nav-item nav-link {{ $warrantyClaim->getCurrentStage() == 'claim_validation' ? 'active' : "" }} {{ in_array('claim_validation', $currentStages) ? "" : "in-active-tab" }}" 
                            id="claim-validation-tab" 
                            data-toggle="tab" href="#claim_validation" role="tab" 
                            aria-selected="{{ $warrantyClaim->getCurrentStage() == 'claim_validation' }}">
                            Create Claim Validation
                        </a>
                        <a class="nav-item nav-link {{ $warrantyClaim->getCurrentStage() == 'claim_action' ? 'active' : "" }} {{ in_array('claim_action', $currentStages) ? "" : "in-active-tab" }}" 
                            id="claim-action-tab" 
                            data-toggle="tab" href="#claim_action" role="tab" 
                            aria-selected="{{ $warrantyClaim->getCurrentStage() == 'claim_action' }}">
                            Start Claim Action
                        </a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show {{ $warrantyClaim->getCurrentStage() == 'status' ? 'active' : '' }}" 
                        id="status" role="tabpanel" aria-labelledby="session-tab">
                        @include('admin.warrantyClaims.edit')
                    </div>

                    <div class="tab-pane fade show {{ $warrantyClaim->getCurrentStage() == 'pdf_upload' ? 'active' : '' }}" 
                        id="pdf_upload" role="tabpanel" aria-labelledby="session-tab">
                        @if($warrantyClaim->status != 'rejected')
                            @include('admin.warrantyClaims.claimPdf')
                        @endif
                    </div>

                    <div class="tab-pane fade show {{ $warrantyClaim->getCurrentStage() == 'claim_validation' ? 'active' : '' }}" id="claim_validation" role="tabpanel" aria-labelledby="session-tab">
                        @if($warrantyClaim->status != 'submitted')
                            @include('admin.warrantyClaimValidations.create')
                        @endif
                    </div>

                    <div class="tab-pane fade show {{ $warrantyClaim->getCurrentStage() == 'claim_action' ? 'active' : '' }}" id="claim_action" role="tabpanel" aria-labelledby="session-tab">
                        @if($warrantyClaim->warranty_claim_action)
                            @include('admin.warrantyClaimActions.pdfs')
    
                            <button class="btn btn-save" onclick="$('#claim_action_collapse').toggle()">
                                Edit Claim Action
                            </button>
                            @include('admin.warrantyClaimActions.editForm', ['warrantyClaimAction' => $warrantyClaim->warranty_claim_action])
                        @else
                            @include('admin.warrantyClaimActions.form')
                        @endif
                    </div>

                </div>
            </div>

            <div class="form-group mt-3">
                <a class="btn btn-create" href="{{ route('admin.warranty-claims.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection

@section('scripts')
    <script>
        let claimPdfUploadButton = document.getElementById('upload-claim-pdf')
        let warrantyClaimEditClaimPdfButton = document.getElementById('warranty-claim-edit-claim-pdf')                
        function loadSpinner() {
            claimPdfUploadButton.innerHTML = 'Uploading <i class="fas fa-spinner fa-spin"></i>';
        }
        function loadSpinnerEditClaim () {
            warrantyClaimEditClaimPdfButton.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>';
        }
    </script>
@endsection