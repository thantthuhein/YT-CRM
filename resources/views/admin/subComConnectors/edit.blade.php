@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.subComConnector.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sub-com-connectors.update", [$subComConnector->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="sub_com_id">{{ trans('cruds.subComConnector.fields.sub_com') }}</label>
                <select class="form-control select2 {{ $errors->has('sub_com') ? 'is-invalid' : '' }}" name="sub_com_id" id="sub_com_id">
                    @foreach($sub_coms as $id => $sub_com)
                        <option value="{{ $id }}" {{ ($subComConnector->sub_com ? $subComConnector->sub_com->id : old('sub_com_id')) == $id ? 'selected' : '' }}>{{ $sub_com }}</option>
                    @endforeach
                </select>
                @if($errors->has('sub_com_id'))
                    <span class="text-danger">{{ $errors->first('sub_com_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComConnector.fields.sub_com_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sub_com_installation_id">{{ trans('cruds.subComConnector.fields.sub_com_installation') }}</label>
                <select class="form-control select2 {{ $errors->has('sub_com_installation') ? 'is-invalid' : '' }}" name="sub_com_installation_id" id="sub_com_installation_id">
                    @foreach($sub_com_installations as $id => $sub_com_installation)
                        <option value="{{ $id }}" {{ ($subComConnector->sub_com_installation ? $subComConnector->sub_com_installation->id : old('sub_com_installation_id')) == $id ? 'selected' : '' }}>{{ $sub_com_installation }}</option>
                    @endforeach
                </select>
                @if($errors->has('sub_com_installation_id'))
                    <span class="text-danger">{{ $errors->first('sub_com_installation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComConnector.fields.sub_com_installation_helper') }}</span>
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