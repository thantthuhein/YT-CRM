@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.paymentHistory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.payment-histories.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="sale_contract_id">{{ trans('cruds.paymentHistory.fields.sale_contract') }}</label>
                <select class="form-control select2 {{ $errors->has('sale_contract') ? 'is-invalid' : '' }}" name="sale_contract_id" id="sale_contract_id" required>
                    @foreach($sale_contracts as $id => $sale_contract)
                        <option value="{{ $id }}" {{ old('sale_contract_id') == $id ? 'selected' : '' }}>{{ $sale_contract }}</option>
                    @endforeach
                </select>
                @if($errors->has('sale_contract_id'))
                    <span class="text-danger">{{ $errors->first('sale_contract_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.paymentHistory.fields.sale_contract_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_step_from">{{ trans('cruds.paymentHistory.fields.payment_step_from') }}</label>
                <input class="form-control {{ $errors->has('payment_step_from') ? 'is-invalid' : '' }}" type="number" name="payment_step_from" id="payment_step_from" value="{{ old('payment_step_from') }}" step="1">
                @if($errors->has('payment_step_from'))
                    <span class="text-danger">{{ $errors->first('payment_step_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.paymentHistory.fields.payment_step_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_step_to">{{ trans('cruds.paymentHistory.fields.payment_step_to') }}</label>
                <input class="form-control {{ $errors->has('payment_step_to') ? 'is-invalid' : '' }}" type="number" name="payment_step_to" id="payment_step_to" value="{{ old('payment_step_to') }}" step="1">
                @if($errors->has('payment_step_to'))
                    <span class="text-danger">{{ $errors->first('payment_step_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.paymentHistory.fields.payment_step_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.paymentHistory.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.paymentHistory.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.paymentHistory.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ old('updated_by_id') == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.paymentHistory.fields.updated_by_helper') }}</span>
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