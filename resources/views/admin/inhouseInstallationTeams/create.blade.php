@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.inhouseInstallationTeam.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.inhouse-installation-teams.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="servicing_team_id">{{ trans('cruds.inhouseInstallationTeam.fields.servicing_team') }}</label>
                <select class="form-control select2 {{ $errors->has('servicing_team') ? 'is-invalid' : '' }}" name="servicing_team_id" id="servicing_team_id">
                    @foreach($servicing_teams as $id => $servicing_team)
                        <option value="{{ $id }}" {{ old('servicing_team_id') == $id ? 'selected' : '' }}>{{ $servicing_team }}</option>
                    @endforeach
                </select>
                @if($errors->has('servicing_team_id'))
                    <span class="text-danger">{{ $errors->first('servicing_team_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inhouseInstallationTeam.fields.servicing_team_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="inhouse_installation_id">{{ trans('cruds.inhouseInstallationTeam.fields.inhouse_installation') }}</label>
                <select class="form-control select2 {{ $errors->has('inhouse_installation') ? 'is-invalid' : '' }}" name="inhouse_installation_id" id="inhouse_installation_id">
                    @foreach($inhouse_installations as $id => $inhouse_installation)
                        <option value="{{ $id }}" {{ old('inhouse_installation_id') == $id ? 'selected' : '' }}>{{ $inhouse_installation }}</option>
                    @endforeach
                </select>
                @if($errors->has('inhouse_installation_id'))
                    <span class="text-danger">{{ $errors->first('inhouse_installation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inhouseInstallationTeam.fields.inhouse_installation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.inhouseInstallationTeam.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inhouseInstallationTeam.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.inhouseInstallationTeam.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ old('updated_by_id') == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inhouseInstallationTeam.fields.updated_by_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection