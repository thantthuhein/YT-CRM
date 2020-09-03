@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.airconTypeConnector.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.aircon-type-connectors.update", [$airconTypeConnector->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="enquiries_id">{{ trans('cruds.airconTypeConnector.fields.enquiries') }}</label>
                <select class="form-control select2 {{ $errors->has('enquiries') ? 'is-invalid' : '' }}" name="enquiries_id" id="enquiries_id">
                    @foreach($enquiries as $id => $enquiries)
                        <option value="{{ $id }}" {{ ($airconTypeConnector->enquiries ? $airconTypeConnector->enquiries->id : old('enquiries_id')) == $id ? 'selected' : '' }}>{{ $enquiries }}</option>
                    @endforeach
                </select>
                @if($errors->has('enquiries_id'))
                    <span class="text-danger">{{ $errors->first('enquiries_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.airconTypeConnector.fields.enquiries_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="aircon_types">{{ trans('cruds.airconTypeConnector.fields.aircon_type') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('aircon_types') ? 'is-invalid' : '' }}" name="aircon_types[]" id="aircon_types" multiple>
                    @foreach($aircon_types as $id => $aircon_type)
                        <option value="{{ $id }}" {{ (in_array($id, old('aircon_types', [])) || $airconTypeConnector->aircon_types->contains($id)) ? 'selected' : '' }}>{{ $aircon_type }}</option>
                    @endforeach
                </select>
                @if($errors->has('aircon_types'))
                    <span class="text-danger">{{ $errors->first('aircon_types') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.airconTypeConnector.fields.aircon_type_helper') }}</span>
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