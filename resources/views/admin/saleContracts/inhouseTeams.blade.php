<div class="card p-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Leader
                        </th>
                        <th>
                            Man Power
                        </th>
                        <th>
                            Active
                        </th>
                        <th>
                            Est Start Date
                        </th>
                        <th>
                            Est End Date
                        </th>
                        <th>
                            Actual Start Date
                        </th>
                        <th>
                            Actual End Date
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Site Engineer
                        </th>
                    </tr>
                </thead>
                        
                @if($saleContract->inHouseInstallation && count($saleContract->inHouseInstallation->inhouseInstallationTeams) > 0)
                    @foreach($saleContract->inHouseInstallation->inhouseInstallationTeams as $inhouseTeam)
                        <tbody>
                            <tr data-entry-id="{{ $inhouseTeam->id }}">
                                <td>
                                    {{ $inhouseTeam->servicing_team->leader_name ?? '' }}
                                </td>
                                <td>
                                    {{ $inhouseTeam->servicing_team->man_power ?? '' }}
                                </td>
                                <td>
                                    {{ $inhouseTeam->servicing_team->is_active ? 'TRUE' : "FALSE" }}
                                </td>
                                <td>
                                    {{ $saleContract->inHouseInstallation->estimate_start_date ?? '' }}
                                </td>
                                <td>
                                    {{ $saleContract->inHouseInstallation->estimate_end_date ?? '' }}
                                </td>
                                <td>
                                    {{ $saleContract->inHouseInstallation->actual_start_date ?? '' }}
                                </td>
                                <td>
                                    {{ $saleContract->inHouseInstallation->actual_end_date ?? '' }}
                                </td>
                                <td>
                                    {{ $saleContract->inHouseInstallation->status ?? '' }}
                                </td>
                                <td>
                                    {{-- <form action="{{ route('admin.in-house-installations.destroy', $saleContract->inHouseInstallation) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form> --}}
                                    
                                    @if ($saleContract->inHouseInstallation->site_engineer)                                
                                        {{ $saleContract->inHouseInstallation->site_engineer->name  ?? ''}}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>