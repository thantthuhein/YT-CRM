@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.onCall.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.on-calls.update", [$onCall->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.onCall.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id">
                    @foreach($projects as $id => $project)
                        <option value="{{ $id }}" {{ ($onCall->project ? $onCall->project->id : old('project_id')) == $id ? 'selected' : '' }}>{{ $project }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_id'))
                    <span class="text-danger">{{ $errors->first('project_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.onCall.fields.project_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="service_type_id">{{ trans('cruds.onCall.fields.service_type') }}</label>
                <select class="form-control select2 {{ $errors->has('service_type') ? 'is-invalid' : '' }}" name="service_type_id" id="service_type_id">
                    @foreach($service_types as $id => $service_type)
                        <option value="{{ $id }}" {{ ($onCall->service_type ? $onCall->service_type->id : old('service_type_id')) == $id ? 'selected' : '' }}>{{ $service_type }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_type_id'))
                    <span class="text-danger">{{ $errors->first('service_type_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.onCall.fields.service_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.onCall.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark', $onCall->remark) !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.onCall.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.onCall.fields.is_new_customer') }}</label>
                @foreach(App\OnCall::IS_NEW_CUSTOMER_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('is_new_customer') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="is_new_customer_{{ $key }}" name="is_new_customer" value="{{ $key }}" {{ old('is_new_customer', $onCall->is_new_customer) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_new_customer_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('is_new_customer'))
                    <span class="text-danger">{{ $errors->first('is_new_customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.onCall.fields.is_new_customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="customer_id">{{ trans('cruds.onCall.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id">
                    @foreach($customers as $id => $customer)
                        <option value="{{ $id }}" {{ ($onCall->customer ? $onCall->customer->id : old('customer_id')) == $id ? 'selected' : '' }}>{{ $customer }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer_id'))
                    <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.onCall.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.onCall.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ ($onCall->created_by ? $onCall->created_by->id : old('created_by_id')) == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.onCall.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.onCall.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ ($onCall->updated_by ? $onCall->updated_by->id : old('updated_by_id')) == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.onCall.fields.updated_by_helper') }}</span>
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