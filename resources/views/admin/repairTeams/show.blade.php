@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.repairTeam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>                    
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeam.fields.leader_name') }}
                        </th>
                        <td>
                            {{ $repairTeam->leader_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeam.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $repairTeam->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeam.fields.man_power') }}
                        </th>
                        <td>
                            {{ $repairTeam->man_power }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeam.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\RepairTeam::IS_ACTIVE_RADIO[$repairTeam->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeam.fields.created_by') }}
                        </th>
                        <td>
                            {{ $repairTeam->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeam.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $repairTeam->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="card display-card">
                <div class="card-header">
                    Repairs
                </div>
                <div class="card-body">
                    <table class="en-list table table-borderless table-striped scrollbar">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($connectors as $key => $repair_team)
                                <tr>
                                    <td>{{ $repair_team->created_at->format('d-M-Y') }}</td>
                                    <td>
                                        @if ($repair_team->repair->oncall->sale_contract->project)
                                        <a href="{{ route('admin.repairs.show', $repair_team->repair_id) }}">
                                            {{ $repair_team->repair->oncall->sale_contract->project->name }}
                                        </a>    
                                        @else                                            
                                        <a href="{{ route('admin.repairs.show', $repair_team->repair_id) }}">Repair {{++$key }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="my-3">
                        {{ $connectors->links() }}
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <a class="btn btn-create" href="{{ route('admin.repair-teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection