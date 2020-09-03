{{-- @extends('layouts.admin')
@section('content') --}}

<div class="card text-dark">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.warrantyClaimValidation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.warranty-claims.warranty-claim-validations.store", [$warrantyClaim]) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="repair_team_id">{{ trans('cruds.warrantyClaimValidation.fields.repair_team') }}</label>
                <select class="form-control select2 {{ $errors->has('repair_team') ? 'is-invalid' : '' }}" name="repair_team_id" id="repair_team_id" style="width: 100%">
                    @foreach($repair_teams as $id => $repair_team)
                        <option value="{{ $id }}" {{ old('repair_team_id', optional($warrantyClaim->warranty_claim_validation)->repair_team_id) == $id ? 'selected' : '' }}>{{ $repair_team }}</option>
                    @endforeach
                </select>
                @if($errors->has('repair_team_id'))
                    <span class="text-danger">{{ $errors->first('repair_team_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimValidation.fields.repair_team_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="actual_date">{{ trans('cruds.warrantyClaimValidation.fields.actual_date') }}</label>
                <input class="form-control date {{ $errors->has('actual_date') ? 'is-invalid' : '' }}" 
                            type="text" name="actual_date" 
                            id="actual_date" 
                            value="{{ old('actual_date', optional($warrantyClaim->warranty_claim_validation)->actual_date) }}">
                @if($errors->has('actual_date'))
                    <span class="text-danger">{{ $errors->first('actual_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimValidation.fields.actual_date_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    {{ $warrantyClaim->warranty_claim_validation ? "Update" : trans('global.save')}}
                </button>
            </div>
        </form>


    </div>
</div>