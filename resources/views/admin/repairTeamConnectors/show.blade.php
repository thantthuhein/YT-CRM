@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.repairTeamConnector.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.repair-team-connectors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeamConnector.fields.id') }}
                        </th>
                        <td>
                            {{ $repairTeamConnector->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeamConnector.fields.repair') }}
                        </th>
                        <td>
                            {{ $repairTeamConnector->repair->estimate_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeamConnector.fields.morphable') }}
                        </th>
                        <td>
                            {{ $repairTeamConnector->morphable }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairTeamConnector.fields.morphable_type') }}
                        </th>
                        <td>
                            {{ $repairTeamConnector->morphable_type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.repair-team-connectors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection