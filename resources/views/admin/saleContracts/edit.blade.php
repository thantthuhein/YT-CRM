@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.saleContract.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sale-contracts.update", [$saleContract->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="morphable">{{ trans('cruds.saleContract.fields.morphable') }}</label>
                <input class="form-control {{ $errors->has('morphable') ? 'is-invalid' : '' }}" type="number" name="morphable" id="morphable" value="{{ old('morphable', $saleContract->morphable) }}" step="1">
                @if($errors->has('morphable'))
                    <span class="text-danger">{{ $errors->first('morphable') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.morphable_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="morphable_type">{{ trans('cruds.saleContract.fields.morphable_type') }}</label>
                <input class="form-control {{ $errors->has('morphable_type') ? 'is-invalid' : '' }}" type="text" name="morphable_type" id="morphable_type" value="{{ old('morphable_type', $saleContract->morphable_type) }}">
                @if($errors->has('morphable_type'))
                    <span class="text-danger">{{ $errors->first('morphable_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.morphable_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.saleContract.fields.has_installation') }}</label>
                @foreach(App\SaleContract::HAS_INSTALLATION_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('has_installation') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="has_installation_{{ $key }}" name="has_installation" value="{{ $key }}" {{ old('has_installation', $saleContract->has_installation) === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="has_installation_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('has_installation'))
                    <span class="text-danger">{{ $errors->first('has_installation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.has_installation_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.saleContract.fields.installation_type') }}</label>
                <select class="form-control {{ $errors->has('installation_type') ? 'is-invalid' : '' }}" name="installation_type" id="installation_type">
                    <option value disabled {{ old('installation_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\SaleContract::INSTALLATION_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('installation_type', $saleContract->installation_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('installation_type'))
                    <span class="text-danger">{{ $errors->first('installation_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.installation_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_terms">{{ trans('cruds.saleContract.fields.payment_terms') }}</label>
                <input class="form-control {{ $errors->has('payment_terms') ? 'is-invalid' : '' }}" type="number" name="payment_terms" id="payment_terms" value="{{ old('payment_terms', $saleContract->payment_terms) }}" step="1">
                @if($errors->has('payment_terms'))
                    <span class="text-danger">{{ $errors->first('payment_terms') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.payment_terms_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="current_payment_step">{{ trans('cruds.saleContract.fields.current_payment_step') }}</label>
                <input class="form-control {{ $errors->has('current_payment_step') ? 'is-invalid' : '' }}" type="number" name="current_payment_step" id="current_payment_step" value="{{ old('current_payment_step', $saleContract->current_payment_step) }}" step="1">
                @if($errors->has('current_payment_step'))
                    <span class="text-danger">{{ $errors->first('current_payment_step') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.current_payment_step_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_status">{{ trans('cruds.saleContract.fields.payment_status') }}</label>
                <input class="form-control {{ $errors->has('payment_status') ? 'is-invalid' : '' }}" type="text" name="payment_status" id="payment_status" value="{{ old('payment_status', $saleContract->payment_status) }}">
                @if($errors->has('payment_status'))
                    <span class="text-danger">{{ $errors->first('payment_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.payment_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.saleContract.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ ($saleContract->created_by ? $saleContract->created_by->id : old('created_by_id')) == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.saleContract.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ ($saleContract->updated_by ? $saleContract->updated_by->id : old('updated_by_id')) == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.updated_by_helper') }}</span>
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