<form method="POST" action="{{ route("admin.repairs.update", [$repair->id]) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="estimate_date">{{ trans('cruds.repair.fields.estimate_date') }}</label>
        <input class="form-control date {{ $errors->has('estimate_date') ? 'is-invalid' : '' }}" type="text" name="estimate_date" id="estimate_date" value="{{ old('estimate_date', $repair->estimate_date) }}">
        @if($errors->has('estimate_date'))
            <span class="text-danger">{{ $errors->first('estimate_date') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.repair.fields.estimate_date_helper') }}</span>
    </div>

    <div class="form-group">
        <label>{{ trans('cruds.repair.fields.team_type') }}</label>
        <select 
        {{ $repair->repairTeamConnectors->isEmpty() ? '' : 'disabled' }}
        class="form-control {{ $errors->has('team_type') ? 'is-invalid' : '' }}" name="team_type" id="team_type" onchange="checkTeamType()">
            <option value disabled {{ old('team_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
            @foreach(App\Repair::TEAM_TYPE_SELECT as $key => $label)
                <option value="{{ $key }}" {{ old('team_type', $repair->team_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @if($errors->has('team_type'))
            <span class="text-danger">{{ $errors->first('team_type') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.repair.fields.team_type_helper') }}</span>
    </div>

    @if (!$repair->repairTeamConnectors || $repair->repairTeamConnectors->isEmpty())                               
                
        <div class="form-group" id="inhouse-team" style="display:{{ old('team_type', $repair->team_type) == 'subcom' ? 'none': 'block' }};">
            <label for="servicing_team_id" class="d-block">{{ trans('cruds.repairTeam.title_singular') }}</label>

            <select style="width:100%;" 
                class="form-control select2 {{ $errors->has('repair_team_id') ? 'is-invalid' : '' }}" name="repair_team_id" id="repair_team_id">
                <option value disabled {{ old('repair_team_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                @foreach($repairTeams as  $repairTeam)
                    <option 
                    value="{{ $repairTeam->id }}" 
                    {{ old('repair_team_id', '') == $repairTeam->id ? 'selected' : '' }}
                    >
                        {{ $repairTeam->leader_name }}
                    </option>
                    
                @endforeach
            </select>

            @if($errors->has('repair_team_id'))
                <span class="text-danger">{{ $errors->first('repair_team_id') }}</span>
            @endif
        </div>  
    
        <div class="form-group" id="subcom-team" style="display:{{ old('team_type', $repair->team_type) == 'inhouse' ? 'none': 'block' }};">
            <label for="subcom_team_id" class="d-block">Sub Companies</label>

            <select style="width:100%;" 
            class="form-control select2 {{ $errors->has('subcom_team_id') ? 'is-invalid' : '' }}" name="subcom_team_id" id="subcom_team_id">
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
    @endif

    <div class="form-group">
        <button class="btn btn-save" {{ $repair->repairTeamConnectors->isEmpty() ? '' : 'disabled' }} type="submit">
            {{ trans('global.update') }}
        </button>
    </div>
</form>

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

        } else if ( teamType.value == 'Both' ) {

            inhouseTeam.style.display = 'block';
            subcomTeam.style.display = 'block';

        }
        
    }

</script>
@endsection