<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.site_engineer') }}
            </th>
            <td>
                {{ $inHouseInstallation->sale_engineer->name ?? '' }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.sale_contract') }}
            </th>
            <td>
                {{ $inHouseInstallation->sale_contract->has_installation ?? '' }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.estimate_start_date') }}
            </th>
            <td>
                {{ $inHouseInstallation->estimate_start_date }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.estimate_end_date') }}
            </th>
            <td>
                {{ $inHouseInstallation->estimate_end_date }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.actual_start_date') }}
            </th>
            <td>
                {{ $inHouseInstallation->actual_start_date }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.actual_end_date') }}
            </th>
            <td>
                {{ $inHouseInstallation->actual_end_date }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.tc_time') }}
            </th>
            <td>
                {{ $inHouseInstallation->tc_time }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.hand_over_date') }}
            </th>
            <td>
                {{ $inHouseInstallation->hand_over_date }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.actual_installation_report_pdf') }}
            </th>
            <td>
                <a href="{{ $inHouseInstallation->actual_installation_report_pdf }}" target="_blank">
                    {{ trans('global.view_file') }}
                </a>
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.service_manager_approve_date') }}
            </th>
            <td>
                {{ $inHouseInstallation->service_manager_approve_date }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.approved_service_manager') }}
            </th>
            <td>
                {{ $inHouseInstallation->approved_service_manager->name ?? '' }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.project_manager_approve_date') }}
            </th>
            <td>
                {{ $inHouseInstallation->project_manager_approve_date }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.approved_project_manager') }}
            </th>
            <td>
                {{ $inHouseInstallation->approved_project_manager->name ?? '' }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.inHouseInstallation.fields.status') }}
            </th>
            <td>
                {{ App\InHouseInstallation::STATUS_SELECT[$inHouseInstallation->status] ?? '' }}
            </td>
        </tr>
    </tbody>
</table>