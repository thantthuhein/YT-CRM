@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.subComInstallation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sub-com-installations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="sale_contract_id">{{ trans('cruds.subComInstallation.fields.sale_contract') }}</label>
                <select class="form-control select2 {{ $errors->has('sale_contract') ? 'is-invalid' : '' }}" name="sale_contract_id" id="sale_contract_id">
                    @foreach($sale_contracts as $id => $sale_contract)
                        <option value="{{ $id }}" {{ old('sale_contract_id') == $id ? 'selected' : '' }}>{{ $sale_contract }}</option>
                    @endforeach
                </select>
                @if($errors->has('sale_contract_id'))
                    <span class="text-danger">{{ $errors->first('sale_contract_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComInstallation.fields.sale_contract_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rating">{{ trans('cruds.subComInstallation.fields.rating') }}</label>
                <input class="form-control {{ $errors->has('rating') ? 'is-invalid' : '' }}" type="number" name="rating" id="rating" value="{{ old('rating') }}" step="1">
                @if($errors->has('rating'))
                    <span class="text-danger">{{ $errors->first('rating') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComInstallation.fields.rating_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="completed_month">{{ trans('cruds.subComInstallation.fields.completed_month') }}</label>
                <input class="form-control date {{ $errors->has('completed_month') ? 'is-invalid' : '' }}" type="text" name="completed_month" id="completed_month" value="{{ old('completed_month') }}">
                @if($errors->has('completed_month'))
                    <span class="text-danger">{{ $errors->first('completed_month') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComInstallation.fields.completed_month_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="completed_year">{{ trans('cruds.subComInstallation.fields.completed_year') }}</label>
                <input class="form-control date {{ $errors->has('completed_year') ? 'is-invalid' : '' }}" type="text" name="completed_year" id="completed_year" value="{{ old('completed_year') }}">
                @if($errors->has('completed_year'))
                    <span class="text-danger">{{ $errors->first('completed_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComInstallation.fields.completed_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="installation_type">{{ trans('cruds.subComInstallation.fields.installation_type') }}</label>
                <input class="form-control {{ $errors->has('installation_type') ? 'is-invalid' : '' }}" type="text" name="installation_type" id="installation_type" value="{{ old('installation_type', '') }}">
                @if($errors->has('installation_type'))
                    <span class="text-danger">{{ $errors->first('installation_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComInstallation.fields.installation_type_helper') }}</span>
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