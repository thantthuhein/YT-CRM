@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        Perform Actual Maintenance
    </div>

    <div class="card-body">
        
        <form method="POST" action="{{ route("admin.servicing-setups.update", [$servicingSetup->id]) }}" enctype="multipart/form-data">

            @method('PUT')
            @csrf
            
            <div class="form-group">
                <input type="hidden" name="project_id" value="{{ $servicingSetup->project->id }}">
            </div>
            

            <div class="form-group">
                <label>{{ trans('cruds.servicingSetup.fields.is_major') }}</label>
                @foreach(App\ServicingSetup::IS_MAJOR_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('is_major') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="is_major_{{ $key }}" name="is_major" value="{{ $key }}" {{ old('is_major', $servicingSetup->is_major) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_major_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('is_major'))
                    <span class="text-danger">{{ $errors->first('is_major') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingSetup.fields.is_major_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="estimated_date">{{ trans('cruds.servicingSetup.fields.estimated_date') }}</label>
                <input class="form-control date {{ $errors->has('estimated_date') ? 'is-invalid' : '' }}" type="text" name="estimated_date" id="estimated_date" value="{{ old('estimated_date', $servicingSetup->estimated_date) }}">
                @if($errors->has('estimated_date'))
                    <span class="text-danger">{{ $errors->first('estimated_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingSetup.fields.estimated_date_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="actual_date">{{ trans('cruds.servicingSetup.fields.actual_date') }}</label>
                <input class="form-control date {{ $errors->has('actual_date') ? 'is-invalid' : '' }}" type="text" name="actual_date" id="actual_date" value="{{ old('actual_date', $servicingSetup->actual_date) }}">
                @if($errors->has('actual_date'))
                    <span class="text-danger">{{ $errors->first('actual_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingSetup.fields.actual_date_helper') }}</span>
            </div>

            @if ($servicingSetup->service_report_pdf)
                <div class="form-group">
                    <p class="font-weight-bold">Uploaded PDF</p>
                    <div class="d-flex">
                        <a href="{{ $servicingSetup->service_report_pdf}}" class="btn btn-sm btn-primary rounded-pill">View PDF</a>
                    </div>
                </div>
            @endif
            <div class="form-group">
                <label for="service_report_pdf">Upload PDF</label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input accept="application/pdf" name="service_report_pdf" type="file" class="custom-file-input {{ $errors->has('service_report_pdf') ? 'is-invalid' : '' }}" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                @if($errors->has('service_report_pdf'))
                    <span class="text-danger">{{ $errors->first('service_report_pdf') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="status">Maintenance Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach (App\ServicingSetup::STATUS as $key => $label)
                        <option value="{{ $key }}" {{ old('status') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="required">{{ trans('cruds.servicingSetup.fields.team_type') }}</label>
                <select onchange="checkTeamType()" class="form-control {{ $errors->has('team_type') ? 'is-invalid' : '' }}" name="team_type" id="team_type" required>
                    <option value disabled {{ old('team_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\ServicingSetup::TEAM_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('team_type', $servicingSetup->team_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('team_type'))
                    <span class="text-danger">{{ $errors->first('team_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingSetup.fields.team_type_helper') }}</span>
            </div>

            {{-- <div class="form-group">
                <p class="font-weight-bold">Assigned Team Leader</p>
                <ul class="list-group list-group-horizontal">
                    @foreach ( $servicingSetup->servicingTeamConnectors as $item)
                    <li class="list-group-item">{{ $item->servicing_team->leader_name }}</li>
                    @endforeach
                </ul>
            </div> --}}
            
            <div class="form-group" id="inhouse-team">
                <label for="servicing_team_id" class="d-block">{{ trans('cruds.inhouseInstallationTeam.fields.servicing_team') }}</label>

                <select style="width:100%;" class="form-control select2 {{ $errors->has('servicing_team_id') ? 'is-invalid' : '' }}" name="servicing_team_id" id="servicing_team_id">
                    <option value disabled {{ old('servicing_team_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($servicingTeams as  $servicingTeam)
                        <option 
                        value="{{ $servicingTeam->id }}" 
                        {{ old('servicing_team_id', '') == $servicingTeam->id ? 'selected' : '' }}
                        >
                            {{ $servicingTeam->leader_name }}
                        </option>
                        
                    @endforeach
                </select>

                @if($errors->has('servicing_team_id'))
                    <span class="text-danger">{{ $errors->first('servicing_team_id') }}</span>
                @endif
            </div>

            <div class="form-group" id="subcom-team">
                <label for="subcom_team_id" class="d-block">Sub Companies</label>

                <select style="width:100%;" class="form-control select2 {{ $errors->has('subcom_team_id') ? 'is-invalid' : '' }}" name="subcom_team_id" id="subcom_team_id">
                    <option value disabled {{ old('subcom_team_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($subcomTeams as  $subcomTeam)
                        <option 
                        value="{{ $subcomTeam->id }}" 
                        {{ old('subcom_team_id', '') == $subcomTeam->id ? 'selected' : '' }}
                        >
                            {{ $subcomTeam->company_name }}
                        </option>
                        
                    @endforeach
                </select>

                @if($errors->has('subcom_team_id'))
                    <span class="text-danger">{{ $errors->first('subcom_team_id') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="remark">{{ trans('cruds.servicingContract.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingContract.fields.remark_helper') }}</span>
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
    $('#customFile').on('change',function(){
        let fileName = document.getElementById("customFile").files[0].name;
        
        $(this).next('.custom-file-label').html(fileName);
    });

    function checkTeamType() {
        let teamType = document.getElementById('team_type');
        let inhouseTeam = document.getElementById('inhouse-team');
        let subcomTeam = document.getElementById('subcom-team');

        if ( teamType.value == 'inhouse') {

            inhouseTeam.style.display = 'block';
            subcomTeam.style.display = 'none';

        } else if ( teamType.value == 'subcom' ) {

            inhouseTeam.style.display = 'none';
            subcomTeam.style.display = 'block';

        } else if ( teamType.value == 'both' ) {

            inhouseTeam.style.display = 'block';
            subcomTeam.style.display = 'block';

        }
        
    }

</script>
@endsection