@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.materialDeliveryProgress.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.material-delivery-progresses.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="inhouse_installation_id">{{ trans('cruds.materialDeliveryProgress.fields.inhouse_installation') }}</label>
                <select class="form-control select2 {{ $errors->has('inhouse_installation') ? 'is-invalid' : '' }}" name="inhouse_installation_id" id="inhouse_installation_id">
                    @foreach($inhouse_installations as $id => $inhouse_installation)
                        <option value="{{ $id }}" {{ old('inhouse_installation_id') == $id ? 'selected' : '' }}>{{ $inhouse_installation }}</option>
                    @endforeach
                </select>
                @if($errors->has('inhouse_installation_id'))
                    <span class="text-danger">{{ $errors->first('inhouse_installation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.materialDeliveryProgress.fields.inhouse_installation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="progress">{{ trans('cruds.materialDeliveryProgress.fields.progress') }}</label>
                <input class="form-control {{ $errors->has('progress') ? 'is-invalid' : '' }}" type="number" name="progress" id="progress" value="{{ old('progress') }}" step="1">
                @if($errors->has('progress'))
                    <span class="text-danger">{{ $errors->first('progress') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.materialDeliveryProgress.fields.progress_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.materialDeliveryProgress.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.materialDeliveryProgress.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.materialDeliveryProgress.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.materialDeliveryProgress.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_updated_by_id">{{ trans('cruds.materialDeliveryProgress.fields.last_updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('last_updated_by') ? 'is-invalid' : '' }}" name="last_updated_by_id" id="last_updated_by_id">
                    @foreach($last_updated_bies as $id => $last_updated_by)
                        <option value="{{ $id }}" {{ old('last_updated_by_id') == $id ? 'selected' : '' }}>{{ $last_updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('last_updated_by_id'))
                    <span class="text-danger">{{ $errors->first('last_updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.materialDeliveryProgress.fields.last_updated_by_helper') }}</span>
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