@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.servicingContract.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.servicing-contracts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.servicingContract.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id">
                    @foreach($projects as $id => $project)
                        <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>{{ $project }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_id'))
                    <span class="text-danger">{{ $errors->first('project_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingContract.fields.project_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.servicingContract.fields.interval') }}</label>
                @foreach(App\ServicingContract::INTERVAL_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('interval') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="interval_{{ $key }}" name="interval" value="{{ $key }}" {{ old('interval', '') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="interval_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('interval'))
                    <span class="text-danger">{{ $errors->first('interval') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingContract.fields.interval_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contract_start_date">{{ trans('cruds.servicingContract.fields.contract_start_date') }}</label>
                <input class="form-control date {{ $errors->has('contract_start_date') ? 'is-invalid' : '' }}" type="text" name="contract_start_date" id="contract_start_date" value="{{ old('contract_start_date') }}">
                @if($errors->has('contract_start_date'))
                    <span class="text-danger">{{ $errors->first('contract_start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingContract.fields.contract_start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contract_end_date">{{ trans('cruds.servicingContract.fields.contract_end_date') }}</label>
                <input class="form-control date {{ $errors->has('contract_end_date') ? 'is-invalid' : '' }}" type="text" name="contract_end_date" id="contract_end_date" value="{{ old('contract_end_date') }}">
                @if($errors->has('contract_end_date'))
                    <span class="text-danger">{{ $errors->first('contract_end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingContract.fields.contract_end_date_helper') }}</span>
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
                <label for="created_by_id">{{ trans('cruds.servicingContract.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingContract.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.servicingContract.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ old('updated_by_id') == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingContract.fields.updated_by_helper') }}</span>
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