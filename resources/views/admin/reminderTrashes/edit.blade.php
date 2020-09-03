@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.reminderTrash.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.reminder-trashes.update", [$reminderTrash->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="reminder_id">{{ trans('cruds.reminderTrash.fields.reminder') }}</label>
                <select class="form-control select2 {{ $errors->has('reminder') ? 'is-invalid' : '' }}" name="reminder_id" id="reminder_id">
                    @foreach($reminders as $id => $reminder)
                        <option value="{{ $id }}" {{ ($reminderTrash->reminder ? $reminderTrash->reminder->id : old('reminder_id')) == $id ? 'selected' : '' }}>{{ $reminder }}</option>
                    @endforeach
                </select>
                @if($errors->has('reminder_id'))
                    <span class="text-danger">{{ $errors->first('reminder_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.reminderTrash.fields.reminder_helper') }}</span>
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