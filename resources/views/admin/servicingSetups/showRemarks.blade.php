<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-RepairRemark">
        <thead>
            <tr>
                <th>
                    Remark
                </th>
                <th>
                    Created By
                </th>
                <th>
                    Last Updated by
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicingSetupRemarks as $key => $servicingSetupRemark)
                <tr>
                    <td>
                        {{ $servicingSetupRemark->remark ?? '' }}
                    </td>
                    <td>
                        {{ $servicingSetupRemark->created_by->name ?? '' }}
                    </td>
                    <td>
                        {{ $servicingSetupRemark->updated_by->name ?? '' }}
                    </td>
                    <td>
                        @can('repair_remark_edit')
                            <a class="btn btn-default rounded-pill" href="{{ route('admin.servicing-setup-remarks.edit', $servicingSetupRemark->id) }}">
                                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                            </a>
                        @endcan

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>