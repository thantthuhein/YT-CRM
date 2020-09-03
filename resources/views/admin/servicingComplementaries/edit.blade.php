@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.servicingComplementary.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.servicing-complementaries.update", [$servicingComplementary->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="inhouse_installation_id">{{ trans('cruds.servicingComplementary.fields.inhouse_installation') }}</label>
                <select class="form-control select2 {{ $errors->has('inhouse_installation') ? 'is-invalid' : '' }}" name="inhouse_installation_id" id="inhouse_installation_id">
                    @foreach($inhouse_installations as $id => $inhouse_installation)
                        <option value="{{ $id }}" {{ ($servicingComplementary->inhouse_installation ? $servicingComplementary->inhouse_installation->id : old('inhouse_installation_id')) == $id ? 'selected' : '' }}>{{ $inhouse_installation }}</option>
                    @endforeach
                </select>
                @if($errors->has('inhouse_installation_id'))
                    <span class="text-danger">{{ $errors->first('inhouse_installation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingComplementary.fields.inhouse_installation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.servicingComplementary.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id">
                    @foreach($projects as $id => $project)
                        <option value="{{ $id }}" {{ ($servicingComplementary->project ? $servicingComplementary->project->id : old('project_id')) == $id ? 'selected' : '' }}>{{ $project }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_id'))
                    <span class="text-danger">{{ $errors->first('project_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingComplementary.fields.project_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="first_maintenance_date">{{ trans('cruds.servicingComplementary.fields.first_maintenance_date') }}</label>
                <input class="form-control date {{ $errors->has('first_maintenance_date') ? 'is-invalid' : '' }}" type="text" name="first_maintenance_date" id="first_maintenance_date" value="{{ old('first_maintenance_date', $servicingComplementary->first_maintenance_date) }}" required>
                @if($errors->has('first_maintenance_date'))
                    <span class="text-danger">{{ $errors->first('first_maintenance_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingComplementary.fields.first_maintenance_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="second_maintenance_date">{{ trans('cruds.servicingComplementary.fields.second_maintenance_date') }}</label>
                <input class="form-control date {{ $errors->has('second_maintenance_date') ? 'is-invalid' : '' }}" type="text" name="second_maintenance_date" id="second_maintenance_date" value="{{ old('second_maintenance_date', $servicingComplementary->second_maintenance_date) }}" required>
                @if($errors->has('second_maintenance_date'))
                    <span class="text-danger">{{ $errors->first('second_maintenance_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingComplementary.fields.second_maintenance_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.servicingComplementary.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ ($servicingComplementary->created_by ? $servicingComplementary->created_by->id : old('created_by_id')) == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingComplementary.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.servicingComplementary.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ ($servicingComplementary->updated_by ? $servicingComplementary->updated_by->id : old('updated_by_id')) == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingComplementary.fields.updated_by_helper') }}</span>
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