<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable">
        <thead>
            <tr>
                <th>
                    Progress
                </th>
                <th>
                    Remark
                </th>
                <th>
                    Created at
                </th>
                <th>
                    Created by
                </th>
                <th>
                    Last Updated by
                </th>
                <th>
                </th>
            </tr>
        </thead>
        <tbody>
            @if($saleContract->inHouseInstallation)
                @foreach($saleContract->inHouseInstallation->installationProgresses as $installationProgress)
                    <tr>
                        <td>
                            {{ $installationProgress->progress }}
                        </td>
                        <td>
                            {{ $installationProgress->remark ?? ""}}
                        </td>
                        <td>
                            {{ $installationProgress->created_at ?? ""}}
                        </td>
                        <td>
                            {{ $installationProgress->created_by->name ?? ""}}
                        </td>
                        <td>
                            {{ $installationProgress->latest_updated_by->name ?? ""}}
                        </td>
                        <td>
                            <a href="{{ route('admin.installation-progresses.edit', [$installationProgress])}}" class='btn btn-default rounded-pill'>
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>