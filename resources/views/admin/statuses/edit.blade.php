@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.status.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.statuses.update", [$status->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="morphable">{{ trans('cruds.status.fields.morphable') }}</label>
                <input class="form-control {{ $errors->has('morphable') ? 'is-invalid' : '' }}" type="number" name="morphable" id="morphable" value="{{ old('morphable', $status->morphable) }}" step="1">
                @if($errors->has('morphable'))
                    <span class="text-danger">{{ $errors->first('morphable') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.status.fields.morphable_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="morphable_type">{{ trans('cruds.status.fields.morphable_type') }}</label>
                <input class="form-control {{ $errors->has('morphable_type') ? 'is-invalid' : '' }}" type="text" name="morphable_type" id="morphable_type" value="{{ old('morphable_type', $status->morphable_type) }}">
                @if($errors->has('morphable_type'))
                    <span class="text-danger">{{ $errors->first('morphable_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.status.fields.morphable_type_helper') }}</span>
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