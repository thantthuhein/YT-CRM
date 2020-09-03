@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.servicingTeamConnector.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.servicing-team-connectors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeamConnector.fields.id') }}
                        </th>
                        <td>
                            {{ $servicingTeamConnector->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeamConnector.fields.servicing_setup') }}
                        </th>
                        <td>
                            {{ $servicingTeamConnector->servicing_setup->is_major ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeamConnector.fields.morphable') }}
                        </th>
                        <td>
                            {{ $servicingTeamConnector->morphable }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicingTeamConnector.fields.morphable_type') }}
                        </th>
                        <td>
                            {{ $servicingTeamConnector->morphable_type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.servicing-team-connectors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection