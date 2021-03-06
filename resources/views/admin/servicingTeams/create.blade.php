@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.servicingTeam.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.servicing-teams.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="leader_name">{{ trans('cruds.servicingTeam.fields.leader_name') }}</label>
                <input class="form-control {{ $errors->has('leader_name') ? 'is-invalid' : '' }}" type="text" name="leader_name" id="leader_name" value="{{ old('leader_name', '') }}">
                @if($errors->has('leader_name'))
                    <span class="text-danger">{{ $errors->first('leader_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingTeam.fields.leader_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone_number">{{ trans('cruds.servicingTeam.fields.phone_number') }}</label>
                <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="number" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" step="1">
                @if($errors->has('phone_number'))
                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingTeam.fields.phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="man_power">{{ trans('cruds.servicingTeam.fields.man_power') }}</label>
                <input class="form-control {{ $errors->has('man_power') ? 'is-invalid' : '' }}" type="number" name="man_power" id="man_power" value="{{ old('man_power') }}" step="1">
                @if($errors->has('man_power'))
                    <span class="text-danger">{{ $errors->first('man_power') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingTeam.fields.man_power_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.servicingTeam.fields.is_active') }}</label>
                @foreach(App\ServicingTeam::IS_ACTIVE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="is_active_{{ $key }}" name="is_active" value="{{ $key }}" {{ old('is_active', '1') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('is_active'))
                    <span class="text-danger">{{ $errors->first('is_active') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingTeam.fields.is_active_helper') }}</span>
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