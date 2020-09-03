@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.serviceType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.service-types.update", [$serviceType->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="type">{{ trans('cruds.serviceType.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', $serviceType->type) }}">
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceType.fields.type_helper') }}</span>
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