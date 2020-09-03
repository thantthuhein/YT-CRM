<div class="card text-dark">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.warrantyClaimAction.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.warranty-claims.warranty-claim-actions.store", [$warrantyClaim]) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="daikin_rep_name">{{ trans('cruds.warrantyClaimAction.fields.daikin_rep_name') }}</label>
                <input class="form-control {{ $errors->has('daikin_rep_name') ? 'is-invalid' : '' }}" type="text" name="daikin_rep_name" id="daikin_rep_name" value="{{ old('daikin_rep_name', '') }}">
                @if($errors->has('daikin_rep_name'))
                    <span class="text-danger">{{ $errors->first('daikin_rep_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.daikin_rep_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="daikin_rep_phone_number">{{ trans('cruds.warrantyClaimAction.fields.daikin_rep_phone_number') }}</label>
                <input class="form-control {{ $errors->has('daikin_rep_phone_number') ? 'is-invalid' : '' }}" type="number" name="daikin_rep_phone_number" id="daikin_rep_phone_number" value="{{ old('daikin_rep_phone_number') }}" step="1">
                @if($errors->has('daikin_rep_phone_number'))
                    <span class="text-danger">{{ $errors->first('daikin_rep_phone_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.daikin_rep_phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="repair_team_id">Repair Team</label>
                <select class="form-control select2 {{ $errors->has('repair_team_id') ? 'is-invalid' : '' }}" name="repair_team_id" id="repair_team_id" style="width: 100%" required>
                    @foreach($repair_teams as $id => $leader_name)
                        <option value="{{ $id }}" {{ old('repair_team_id') == $id ? 'selected' : '' }}>{{ $leader_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('repair_team_id'))
                    <span class="text-danger">{{ $errors->first('repair_team_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.onCall.fields.service_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="estimate_date">{{ trans('cruds.warrantyClaimAction.fields.estimate_date') }}</label>
                <input class="form-control date {{ $errors->has('estimate_date') ? 'is-invalid' : '' }}" type="text" name="estimate_date" id="estimate_date" value="{{ old('estimate_date') }}">
                @if($errors->has('estimate_date'))
                    <span class="text-danger">{{ $errors->first('estimate_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.estimate_date_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
