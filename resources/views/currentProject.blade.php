<div class="p-0">
    <div class="project-box-wrapper pt-0">
        @if ($currentProject->count())            
            <div class="project-box pr-0 mr-0">
                <div class="p-0">
                    <p class="text-muted">Project Name</p> 

                    <h5>{{ $currentProject->project->name ?? ''}}</h5>
                </div>
                <br>
                <div class="p-0">
                    <p class="text-muted">Customer Name</p> 

                    <h5>{{ $currentProject->customer->name ?? '' }}</h5>
                </div>
                <br>
                <div class="p-0">
                    <p class="text-muted">Allocate Team</p> 

                    <h5>{{ implode(" + ", $currentProject->inHouseInstallation->inhouseInstallationTeams->pluck('servicing_team.leader_name')->toArray())}} </h5>
                </div>

                <br>

                <div class="p-0 pt-4">
                    <i class="fas fa-info-circle"></i>
                    <a href="{{ route('admin.in-house-installations.show', [$currentProject->inHouseInstallation->id]) }}" class="text-light">View Details</a>
                </div>
            </div>

            <div class="project-box-2">

                <div class="p-0">
                    <p class="mb-2">Installation Progress {{ $currentProject->inHouseInstallation->installationProgresses->last()->progress ?? " 0 " }} %</p>

                    {{-- <div class="bg-dark p-0">
                        <installation-graph></installation-graph>
                    </div> --}}
                    @php
                        $progress = $currentProject->inHouseInstallation->installationProgresses->last()->progress ?? 0;
                    @endphp
                    <div class="progress bg-dark" style="height: 15px; margin-bottom: 10px">
                        @if ($progress == 100)
                            <div class="progress-bar bg-success"    
                        @elseif ($progress <= 99 && $progress >= 70 )
                            <div class="progress-bar bg-primary"
                        @elseif ($progress < 70 && $progress >= 40)
                            <div class="progress-bar bg-warning"
                        @elseif ($progress < 40 && $progress >= 15)
                            <div class="progress-bar bg-secondary"
                        @elseif ($progress < 15)
                            <div class="progress-bar bg-danger"
                        @endif
                        
                        
                        role="progressbar" style="color: black;width: {{ $progress }}%;" value={{ $progress }} aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            {{-- {{ $progress == 100 ? "Completed" : "Current" }} {{ $progress ?? 0}}% --}}
                        </div>
                    </div>
                </div>

                <div class="p-0 pt-3">
                    <p class="mb-2">Delivery Progress {{ $currentProject->inHouseInstallation->materialDeliveryProgresses->last()->progress ?? " 0 " }} %</p>

                    <div class="bg-dark p-0">
                        {{-- <delivery-graph></delivery-graph> --}}
                    </div>
                    @php
                        $progress = $currentProject->inHouseInstallation->materialDeliveryProgresses->last()->progress ?? 0;
                    @endphp
                    <div class="progress bg-dark" style="height: 15px; margin-bottom: 10px">
                        @if ($progress == 100)
                            <div class="progress-bar bg-success"    
                        @elseif ($progress <= 99 && $progress >= 70 )
                            <div class="progress-bar bg-primary"
                        @elseif ($progress < 70 && $progress >= 40)
                            <div class="progress-bar bg-warning"
                        @elseif ($progress < 40 && $progress >= 15)
                            <div class="progress-bar bg-secondary"
                        @elseif ($progress < 15)
                            <div class="progress-bar bg-danger"
                        @endif
                        
                        role="progressbar" style="height:15px;color: black;width: {{ $progress }}%;" value={{ $progress }} aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            {{-- {{ $progress == 100 ? "Completed" : "Current" }} {{ $progress ?? 0}}% --}}
                        </div>
                    </div>
                </div>

                <div class="pb-2 px-2 pt-4 mt-3 remark-box">

                    <h5>Remark</h5>
                    <p class="text-secondary">
                        {{$currentProject->inHouseInstallation->materialDeliveryProgresses->last()->remark ?? ""}}
                    </p>
                    <p class="text-right text-secondary">
                        {{ $currentProject->inHouseInstallation->materialDeliveryProgresses->last()->created_by->name ?? "" }}</p>
                </div>

            </div>
        @endif
        
    </div>
</div>