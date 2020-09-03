@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.servicingTeam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.leader_name') }}
                        </th>
                        <td>
                            {{ $servicingTeam->leader_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $servicingTeam->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.man_power') }}
                        </th>
                        <td>
                            {{ $servicingTeam->man_power }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\ServicingTeam::IS_ACTIVE_RADIO[$servicingTeam->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.created_by') }}
                        </th>
                        <td>
                            {{ $servicingTeam->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeam.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $servicingTeam->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="card display-card">
                <div class="card-header">
                    Installations
                </div>
                <div class="card-body">
                    <table class="en-list table table-borderless table-striped scrollbar">
                        <thead>
                            <th>Created At</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($teams as $key => $team)
                                
                            <tr>
                                <td>{{ $team->created_at }}</td>
                                <td>
                                    @if ($team->inhouse_installation->sale_contract->project)
                                    <a href="{{ route('admin.in-house-installations.show', $team->inhouse_installation->id) }}">
                                        {{ $team->inhouse_installation->sale_contract->project->name }}
                                    </a>    
                                    @else                                                
                                    <a href="{{ route('admin.in-house-installations.show', $team->inhouse_installation->id) }}">
                                        Installation {{ ++$key }}
                                    </a>                                     
                                    @endif
                                </td>
                            </tr>                                
                                
                            @endforeach
                        </tbody>
                    </table>

                    <div class="my-2">
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group mt-3">
                <a class="btn btn-create" href="{{ route('admin.servicing-teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection