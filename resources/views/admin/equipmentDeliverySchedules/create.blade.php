@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.equipmentDeliverySchedule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.equipment-delivery-schedules.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="sale_contract_id">{{ trans('cruds.equipmentDeliverySchedule.fields.sale_contract') }}</label>
                <select class="form-control select2 {{ $errors->has('sale_contract') ? 'is-invalid' : '' }}" name="sale_contract_id" id="sale_contract_id">
                    @foreach($sale_contracts as $id => $sale_contract)
                        <option value="{{ $id }}" {{ old('sale_contract_id') == $id ? 'selected' : '' }}>{{ $sale_contract }}</option>
                    @endforeach
                </select>
                @if($errors->has('sale_contract_id'))
                    <span class="text-danger">{{ $errors->first('sale_contract_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.equipmentDeliverySchedule.fields.sale_contract_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.equipmentDeliverySchedule.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.equipmentDeliverySchedule.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="delivered_at">{{ trans('cruds.equipmentDeliverySchedule.fields.delivered_at') }}</label>
                <input class="form-control date {{ $errors->has('delivered_at') ? 'is-invalid' : '' }}" type="text" name="delivered_at" id="delivered_at" value="{{ old('delivered_at') }}">
                @if($errors->has('delivered_at'))
                    <span class="text-danger">{{ $errors->first('delivered_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.equipmentDeliverySchedule.fields.delivered_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.equipmentDeliverySchedule.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.equipmentDeliverySchedule.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.equipmentDeliverySchedule.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ old('updated_by_id') == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.equipmentDeliverySchedule.fields.updated_by_helper') }}</span>
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