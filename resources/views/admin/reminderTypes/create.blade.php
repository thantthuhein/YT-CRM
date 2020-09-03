@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.create') }} Reminder Type
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.reminder-types.store") }}">
            @csrf
            <div class="form-group">
                <label for="type">Type*</label>
                <select name="type" class="form-control">
                    @foreach(\App\ReminderType::TYPES as $key => $value)
                        <option value="{{ $key }}" {{ $key == old('type') ? 'selected' : ''}}>{{ $value }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block"></span>
            </div>

            <div class="form-group">
                <label for="action">Action*</label>
                <input type="text" name="action" class="form-control {{ $errors->has('action') ? 'is-invalid' : '' }}" id="action" required>
                @if($errors->has('action'))
                    <span class="text-danger">{{ $errors->first('action') }}</span>
                @endif
                <span class="help-block">named route for reminder action</span>
            </div>
            <div class="form-group">
                <label for="reminder_model">Related Model</label>
                <input class="form-control {{ $errors->has('reminder_model') ? 'is-invalid' : '' }}" type="text" name="reminder_model" id="reminder_model" value="{{ old('reminder_model') }}">
                @if($errors->has('reminder_model'))
                    <span class="text-danger">{{ $errors->first('reminder_model') }}</span>
                @endif
                <span class="help-block">root model name for reminder</span>
            </div>

            <div class="form-group">
                <label for="role_id">Who to remind</label>

                <select name="role_id[]" multiple class="form-control select2 {{ $errors->has('role_id') ? 'is-invalid' : '' }}">
                    <option value="" disabled>Please select</option>
                    @foreach($roles as $key => $role)
                        <option value="{{ $key }}" {{ in_array($key, old('role_id', [])) ? 'selected' : ''}}>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('role_id'))
                    <span class="text-danger">{{ $errors->first('role_id') }}</span>
                @endif
                <span class="help-block"></span>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description') }}">
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block"></span>
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