@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.repairTeamConnector.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.repair-team-connectors.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="repair_id">{{ trans('cruds.repairTeamConnector.fields.repair') }}</label>
                <select class="form-control select2 {{ $errors->has('repair') ? 'is-invalid' : '' }}" name="repair_id" id="repair_id">
                    @foreach($repairs as $id => $repair)
                        <option value="{{ $id }}" {{ old('repair_id') == $id ? 'selected' : '' }}>{{ $repair }}</option>
                    @endforeach
                </select>
                @if($errors->has('repair_id'))
                    <span class="text-danger">{{ $errors->first('repair_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repairTeamConnector.fields.repair_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="morphable">{{ trans('cruds.repairTeamConnector.fields.morphable') }}</label>
                <input class="form-control {{ $errors->has('morphable') ? 'is-invalid' : '' }}" type="number" name="morphable" id="morphable" value="{{ old('morphable') }}" step="1">
                @if($errors->has('morphable'))
                    <span class="text-danger">{{ $errors->first('morphable') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repairTeamConnector.fields.morphable_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="morphable_type">{{ trans('cruds.repairTeamConnector.fields.morphable_type') }}</label>
                <input class="form-control {{ $errors->has('morphable_type') ? 'is-invalid' : '' }}" type="text" name="morphable_type" id="morphable_type" value="{{ old('morphable_type', '') }}">
                @if($errors->has('morphable_type'))
                    <span class="text-danger">{{ $errors->first('morphable_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repairTeamConnector.fields.morphable_type_helper') }}</span>
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