@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        <p>Make Complementary</p>
    </div>
    
    <div class="card-body">
        <p>T & C Time - {{ optional($sale_contract->inHouseInstallation)->tc_time }}</p>
        
        <form method="POST" action="{{ route("admin.servicing-complementaries.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <input type="hidden" name="inhouse_installation_id" value="{{ optional($sale_contract->inHouseInstallation)->id }}">
            </div>

            <div class="form-group">
                <input 
                type="hidden" 
                name="project_id" 
                value="{{ $sale_contract->customer->enquiries()->first()->project->id ?? '' }}"
                >
            </div>

            <div class="form-group">

                <label for="first_maintenance_date">First Maintenance</label>

                <input 
                class="form-control date {{ $errors->has('first_maintenance_date') ? 'is-invalid' : '' }}" 
                type="text" 
                name="first_maintenance_date" 
                id="first_maintenance_date" 
                value="{{ old('first_maintenance_date', '') }}"
                >
                
                @if($errors->has('first_maintenance_date'))
                    <span class="text-danger">{{ $errors->first('first_maintenance_date') }}</span>
                @endif

            </div>
            

            <div class="form-group">
                <label for="second_maintenance_date">Second Maintenance</label>

                <input 
                class="form-control date {{ $errors->has('second_maintenance_date') ? 'is-invalid' : '' }}" 
                type="text" 
                name="second_maintenance_date" 
                id="second_maintenance_date" 
                value="{{ old('second_maintenance_date', \Carbon\Carbon::parse(optional($sale_contract->inHouseInstallation)->tc_time)->addMonths(12)) }}"
                >
                
                @if($errors->has('second_maintenance_date'))
                    <span class="text-danger">{{ $errors->first('second_maintenance_date') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-save">Save</button>
        </form>

    </div>
</div>
@endsection