@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.installationProgress.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.installation-progresses.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="inhouse_installation_id">{{ trans('cruds.installationProgress.fields.inhouse_installation') }}</label>
                <select class="form-control select2 {{ $errors->has('inhouse_installation') ? 'is-invalid' : '' }}" name="inhouse_installation_id" id="inhouse_installation_id">
                    @foreach($inhouse_installations as $id => $inhouse_installation)
                        <option value="{{ $id }}" {{ old('inhouse_installation_id') == $id ? 'selected' : '' }}>{{ $inhouse_installation }}</option>
                    @endforeach
                </select>
                @if($errors->has('inhouse_installation_id'))
                    <span class="text-danger">{{ $errors->first('inhouse_installation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.installationProgress.fields.inhouse_installation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="progress">{{ trans('cruds.installationProgress.fields.progress') }}</label>
                <input class="form-control {{ $errors->has('progress') ? 'is-invalid' : '' }}" type="number" name="progress" id="progress" value="{{ old('progress') }}" step="1">
                @if($errors->has('progress'))
                    <span class="text-danger">{{ $errors->first('progress') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.installationProgress.fields.progress_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.installationProgress.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.installationProgress.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.installationProgress.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.installationProgress.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="latest_updated_by_id">{{ trans('cruds.installationProgress.fields.latest_updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('latest_updated_by') ? 'is-invalid' : '' }}" name="latest_updated_by_id" id="latest_updated_by_id">
                    @foreach($latest_updated_bies as $id => $latest_updated_by)
                        <option value="{{ $id }}" {{ old('latest_updated_by_id') == $id ? 'selected' : '' }}>{{ $latest_updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('latest_updated_by_id'))
                    <span class="text-danger">{{ $errors->first('latest_updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.installationProgress.fields.latest_updated_by_helper') }}</span>
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