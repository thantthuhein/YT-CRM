@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.warrantyactionTeamConnector.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.warrantyaction-team-connectors.update", [$warrantyactionTeamConnector->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="warranty_action_id">{{ trans('cruds.warrantyactionTeamConnector.fields.warranty_action') }}</label>
                <select class="form-control select2 {{ $errors->has('warranty_action') ? 'is-invalid' : '' }}" name="warranty_action_id" id="warranty_action_id">
                    @foreach($warranty_actions as $id => $warranty_action)
                        <option value="{{ $id }}" {{ ($warrantyactionTeamConnector->warranty_action ? $warrantyactionTeamConnector->warranty_action->id : old('warranty_action_id')) == $id ? 'selected' : '' }}>{{ $warranty_action }}</option>
                    @endforeach
                </select>
                @if($errors->has('warranty_action_id'))
                    <span class="text-danger">{{ $errors->first('warranty_action_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyactionTeamConnector.fields.warranty_action_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="servicing_team_id">{{ trans('cruds.warrantyactionTeamConnector.fields.servicing_team') }}</label>
                <select class="form-control select2 {{ $errors->has('servicing_team') ? 'is-invalid' : '' }}" name="servicing_team_id" id="servicing_team_id">
                    @foreach($servicing_teams as $id => $servicing_team)
                        <option value="{{ $id }}" {{ ($warrantyactionTeamConnector->servicing_team ? $warrantyactionTeamConnector->servicing_team->id : old('servicing_team_id')) == $id ? 'selected' : '' }}>{{ $servicing_team }}</option>
                    @endforeach
                </select>
                @if($errors->has('servicing_team_id'))
                    <span class="text-danger">{{ $errors->first('servicing_team_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyactionTeamConnector.fields.servicing_team_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection