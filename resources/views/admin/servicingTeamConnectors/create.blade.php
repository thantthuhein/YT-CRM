@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.servicingTeamConnector.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.servicing-team-connectors.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="servicing_setup_id">{{ trans('cruds.servicingTeamConnector.fields.servicing_setup') }}</label>
                <select class="form-control select2 {{ $errors->has('servicing_setup') ? 'is-invalid' : '' }}" name="servicing_setup_id" id="servicing_setup_id">
                    @foreach($servicing_setups as $id => $servicing_setup)
                        <option value="{{ $id }}" {{ old('servicing_setup_id') == $id ? 'selected' : '' }}>{{ $servicing_setup }}</option>
                    @endforeach
                </select>
                @if($errors->has('servicing_setup_id'))
                    <span class="text-danger">{{ $errors->first('servicing_setup_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingTeamConnector.fields.servicing_setup_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="morphable">{{ trans('cruds.servicingTeamConnector.fields.morphable') }}</label>
                <input class="form-control {{ $errors->has('morphable') ? 'is-invalid' : '' }}" type="number" name="morphable" id="morphable" value="{{ old('morphable') }}" step="1">
                @if($errors->has('morphable'))
                    <span class="text-danger">{{ $errors->first('morphable') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingTeamConnector.fields.morphable_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="morphable_type">{{ trans('cruds.servicingTeamConnector.fields.morphable_type') }}</label>
                <input class="form-control {{ $errors->has('morphable_type') ? 'is-invalid' : '' }}" type="text" name="morphable_type" id="morphable_type" value="{{ old('morphable_type', '') }}">
                @if($errors->has('morphable_type'))
                    <span class="text-danger">{{ $errors->first('morphable_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingTeamConnector.fields.morphable_type_helper') }}</span>
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