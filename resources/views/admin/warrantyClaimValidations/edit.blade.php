@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.warrantyClaimValidation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.warranty-claim-validations.update", [$warrantyClaimValidation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="repair_team_id">{{ trans('cruds.warrantyClaimValidation.fields.repair_team') }}</label>
                <select class="form-control select2 {{ $errors->has('repair_team') ? 'is-invalid' : '' }}" name="repair_team_id" id="repair_team_id">
                    @foreach($repair_teams as $id => $repair_team)
                        <option value="{{ $id }}" {{ ($warrantyClaimValidation->repair_team ? $warrantyClaimValidation->repair_team->id : old('repair_team_id')) == $id ? 'selected' : '' }}>{{ $repair_team }}</option>
                    @endforeach
                </select>
                @if($errors->has('repair_team_id'))
                    <span class="text-danger">{{ $errors->first('repair_team_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimValidation.fields.repair_team_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="actual_date">{{ trans('cruds.warrantyClaimValidation.fields.actual_date') }}</label>
                <input class="form-control date {{ $errors->has('actual_date') ? 'is-invalid' : '' }}" type="text" name="actual_date" id="actual_date" value="{{ old('actual_date', $warrantyClaimValidation->actual_date) }}">
                @if($errors->has('actual_date'))
                    <span class="text-danger">{{ $errors->first('actual_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimValidation.fields.actual_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.warrantyClaimValidation.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ ($warrantyClaimValidation->created_by ? $warrantyClaimValidation->created_by->id : old('created_by_id')) == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimValidation.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.warrantyClaimValidation.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ ($warrantyClaimValidation->updated_by ? $warrantyClaimValidation->updated_by->id : old('updated_by_id')) == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimValidation.fields.updated_by_helper') }}</span>
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