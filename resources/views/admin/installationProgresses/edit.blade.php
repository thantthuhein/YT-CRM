@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.installationProgress.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.installation-progresses.update", [$installationProgress->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="progress">{{ trans('cruds.installationProgress.fields.progress') }}</label>
                <input class="form-control {{ $errors->has('progress') ? 'is-invalid' : '' }}" type="number" name="progress" id="progress" value="{{ old('progress', $installationProgress->progress) }}" step="1">
                @if($errors->has('progress'))
                    <span class="text-danger">{{ $errors->first('progress') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.installationProgress.fields.progress_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.installationProgress.fields.remark') }}</label>
                <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark', $installationProgress->remark) !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.installationProgress.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    {{ trans('global.update') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection