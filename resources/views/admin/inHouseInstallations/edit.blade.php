@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.inHouseInstallation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.in-house-installations.update", [$inHouseInstallation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
           
            <div class="form-group">
                <label for="site_engineer_id">{{ trans('cruds.inHouseInstallation.fields.site_engineer') }}</label>
                <select class="form-control select2 {{ $errors->has('site_engineer') ? 'is-invalid' : '' }}" name="site_engineer_id" id="site_engineer_id">
                    @if ($inHouseInstallation->site_engineer)                        
                        @foreach($site_engineers as $id => $site_engineer)
                            <option value="{{ $id }}" {{ old('site_engineer_id', $inHouseInstallation->site_engineer->id ) == $id ? 'selected' : '' }}>{{ $site_engineer }}</option>
                        @endforeach
                    @else
                        @foreach($site_engineers as $id => $site_engineer)
                            <option value="{{ $id }}" {{ old('site_engineer_id', '' ) == $id ? 'selected' : '' }}>{{ $site_engineer }}</option>
                        @endforeach
                    @endif
                </select>
                @if($errors->has('site_engineer_id'))
                    <span class="text-danger">{{ $errors->first('site_engineer_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.site_engineer_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="servicing_team_id">{{ trans('cruds.inhouseInstallationTeam.fields.servicing_team') }}</label>
                <select class="form-control select2 {{ $errors->has('servicing_team') ? 'is-invalid' : '' }}" name="servicing_team_id[]" id="servicing_team_id" multiple>
                    <option value="" disabled>Please select</option>
                    @foreach($servicing_teams as $id => $servicing_team)
                        <option value="{{ $id }}" {{ in_array($id, old('servicing_team_id', $service_teams)) ? 'selected' : '' }}>{{ $servicing_team }}</option>
                    @endforeach
                </select>
                @if($errors->has('servicing_team_id'))
                    <span class="text-danger">{{ $errors->first('servicing_team_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inhouseInstallationTeam.fields.servicing_team_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="estimate_start_date">{{ trans('cruds.inHouseInstallation.fields.estimate_start_date') }}</label>
                <input class="form-control date {{ $errors->has('estimate_start_date') ? 'is-invalid' : '' }}" type="text" name="estimate_start_date" id="estimate_start_date" value="{{ old('estimate_start_date', $inHouseInstallation->estimate_start_date) }}" required>
                @if($errors->has('estimate_start_date'))
                    <span class="text-danger">{{ $errors->first('estimate_start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.estimate_start_date_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="estimate_end_date">{{ trans('cruds.inHouseInstallation.fields.estimate_end_date') }}</label>
                <input class="form-control date {{ $errors->has('estimate_end_date') ? 'is-invalid' : '' }}" type="text" name="estimate_end_date" id="estimate_end_date" value="{{ old('estimate_end_date', $inHouseInstallation->estimate_end_date) }}" required>
                @if($errors->has('estimate_end_date'))
                    <span class="text-danger">{{ $errors->first('estimate_end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.estimate_end_date_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="actual_start_date">{{ trans('cruds.inHouseInstallation.fields.actual_start_date') }}</label>
                <input class="form-control date {{ $errors->has('actual_start_date') ? 'is-invalid' : '' }}" type="text" name="actual_start_date" id="actual_start_date" value="{{ old('actual_start_date', $inHouseInstallation->actual_start_date) }}">
                @if($errors->has('actual_start_date'))
                    <span class="text-danger">{{ $errors->first('actual_start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.actual_start_date_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="actual_end_date">{{ trans('cruds.inHouseInstallation.fields.actual_end_date') }}</label>
                <input class="form-control date {{ $errors->has('actual_end_date') ? 'is-invalid' : '' }}" type="text" name="actual_end_date" id="actual_end_date" value="{{ old('actual_end_date', $inHouseInstallation->actual_end_date) }}">
                @if($errors->has('actual_end_date'))
                    <span class="text-danger">{{ $errors->first('actual_end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.actual_end_date_helper') }}</span>
            </div>

            <div class="form-group">
                <label>{{ trans('cruds.inHouseInstallation.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\InHouseInstallation::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $inHouseInstallation->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.status_helper') }}</span>
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

@section('scripts')
<script>
    
</script>
@endsection