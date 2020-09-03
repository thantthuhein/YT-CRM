<form method="POST" action="{{ route("admin.servicing-setups.update", [$servicingSetup->id]) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="estimated_date">Estimated Date</label>
        <input class="form-control date {{ $errors->has('estimated_date') ? 'is-invalid' : '' }}" type="text" name="estimated_date" id="estimated_date" value="{{ old('estimated_date', $servicingSetup->estimated_date) }}">
        @if($errors->has('estimated_date'))
            <span class="text-danger">{{ $errors->first('estimated_date') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label>{{ trans('cruds.repair.fields.team_type') }}</label>
        <select 
        {{ $servicingSetup->servicingTeamConnectors->isEmpty() ? '' : 'disabled' }}
        onchange="checkTeamType()" class="form-control {{ $errors->has('team_type') ? 'is-invalid' : '' }}" name="team_type" id="team_type">
            <option value disabled {{ old('team_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
            @foreach(App\ServicingSetup::TEAM_TYPE_SELECT as $key => $label)
                <option value="{{ $key }}" {{ old('team_type', $servicingSetup->team_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @if($errors->has('team_type'))
            <span class="text-danger">{{ $errors->first('team_type') }}</span>
        @endif
    </div>


    @if ($servicingSetup->servicingTeamConnectors->isEmpty())                               
                
        <div class="form-group" id="inhouse-team" style="display:{{ old('team_type', $servicingSetup->team_type) == 'subcom' ? 'none': 'block' }};">
            <label for="servicing_team_id" class="d-block">{{ trans('cruds.inhouseInstallationTeam.fields.servicing_team') }}</label>

            <select style="width:100%;" 
                class="form-control select2 {{ $errors->has('servicing_team_id') ? 'is-invalid' : '' }}" name="servicing_team_id" id="servicing_team_id">
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
    
        <div class="form-group" id="subcom-team" style="display:{{ old('team_type', $servicingSetup->team_type) == 'inhouse' ? 'none': 'block' }};">
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
        <button class="btn btn-save" type="submit"
        {{ $servicingSetup->servicingTeamConnectors->isEmpty() ? '' : 'disabled' }} 
        >
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

        } else if ( teamType.value == 'both' ) {

            inhouseTeam.style.display = 'block';
            subcomTeam.style.display = 'block';

        }
        
    }

</script>
@endsection