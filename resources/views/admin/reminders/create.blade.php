@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.reminder.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.reminders.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="remindable">{{ trans('cruds.reminder.fields.remindable') }}</label>
                <input class="form-control {{ $errors->has('remindable') ? 'is-invalid' : '' }}" type="number" name="remindable" id="remindable" value="{{ old('remindable') }}" step="1">
                @if($errors->has('remindable'))
                    <span class="text-danger">{{ $errors->first('remindable') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.reminder.fields.remindable_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reminable_type">{{ trans('cruds.reminder.fields.reminable_type') }}</label>
                <input class="form-control {{ $errors->has('reminable_type') ? 'is-invalid' : '' }}" type="text" name="reminable_type" id="reminable_type" value="{{ old('reminable_type', '') }}">
                @if($errors->has('reminable_type'))
                    <span class="text-danger">{{ $errors->first('reminable_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.reminder.fields.reminable_type_helper') }}</span>
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