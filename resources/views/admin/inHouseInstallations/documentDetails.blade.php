<div class="card my-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item p-0">
            <a class="nav-link active" id="handover-file-tab" data-toggle="tab" href="#handover-file" role="tab" aria-controls="handover-file" aria-selected="true">Handover Files</a>
        </li>

        <li class="nav-item p-0">
            <a class="nav-link" id="actual-installation-tab" data-toggle="tab" href="#actual-installation" role="tab" aria-controls="actual-installation" aria-selected="true">Actual Installation Report</a>
        </li>

        <li class="nav-item p-0">
            <a class="nav-link" id="docs-for-sm-tab" data-toggle="tab" href="#docs-for-sm" role="tab" aria-controls="docs-for-sm" aria-selected="true">Documents For Service Manager</a>
        </li>

    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="handover-file" role="tabpanel" aria-labelledby="handover-file-tab">
            @include('admin.inHouseInstallations.handover')
        </div>

        <div class="tab-pane fade" id="actual-installation" role="tabpanel" aria-labelledby="actual-installation-tab">
            <div class="card p-0">
                @if( $inHouseInstallation->sale_contract->projectCompleted() )                    
                    @if (! $inHouseInstallation->actual_installation_report_pdf)
                    <div class="text-center my-3">
                        <a class="btn btn-sm btn-save" href="{{ route('admin.inhouseInstallation.uploadActualInstallationReport', [$inHouseInstallation]) }}">Upload Actual Installation Document</a>
                    </div>
                    @else                            
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Uploaded By</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Actual Installation Report</td>
                                    <td>
                                        {{ $inHouseInstallation->sale_contract->created_by->name ?? '' }}
                                    </td>
                                    <td>
                                        <a href="{{ $inHouseInstallation->actual_installation_report_pdf }}" 
                                        target="_blank"
                                        class="btn btn-sm btn-primary rounded-pill">
                                            <i class="fas fa-eye"></i> View    
                                        </a>
                                        <a href="{{ route('admin.inhouseInstallation.uploadActualInstallationReport', [$inHouseInstallation]) }}" 
                                        class="btn btn-sm btn-primary rounded-pill">
                                            Replace
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif     
                @else
                    <div class="text-center my-3">
                        <h5 class="text-dark">Project Approval Required</h5>
                    </div>
                @endif
            </div>

        </div>

        <div class="tab-pane fade" id="docs-for-sm" role="tabpanel" aria-labelledby="docs-for-sm-tab">
            @if($saleContract->has_installation)
                @include('admin.inHouseInstallations.otherDocsForServiceManager')
            @endif
        </div>

    </div>
</div>