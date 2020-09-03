@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.inhouseInstallationTeam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.inhouseInstallationTeam.fields.servicing_team') }}
                        </th>
                        <td>
                            {{ $inhouseInstallationTeam->servicing_team->leader_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Man Power
                        </td>
                        <td>
                            {{ $inhouseInstallationTeam->servicing_team->man_power ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Phone Number
                        </td>
                        <td>
                            {{ $inhouseInstallationTeam->servicing_team->phone_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Active Status
                        </td>
                        <td>
                            {{ $inhouseInstallationTeam->servicing_team->is_active == true ? 'Active' : 'InActive' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.inhouseInstallationTeam.fields.inhouse_installation') }}
                        </th>
                        <td>
                            {{ $inhouseInstallationTeam->inhouse_installation->estimate_start_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.inhouseInstallationTeam.fields.created_by') }}
                        </th>
                        <td>
                            {{ $inhouseInstallationTeam->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.inhouseInstallationTeam.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $inhouseInstallationTeam->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-create btn-sm" href="{{ route('admin.inhouse-installation-teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection