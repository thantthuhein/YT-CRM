@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.servicingContract.title_singular') }}
    </div>

    <div class="card-body">
        <p>Project Name - {{ $project->name ?? '' }}</p>
        @if ($errors->any())            
        <div class="alert alert-danger" role="alert">
            <ul class="list-unstyled">
                @foreach ($errors->all() as $item)                
                    <li class="list-item">
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
        <hr>

        <form method="POST" action="{{ route("admin.servicing-contracts.store") }}" enctype="multipart/form-data">
            @csrf            

            <div class="form-group">
                <input type="hidden" name="inhouse_installation_id" id="inhouse_installation_id" value="{{ request()->inhouse_installation_id }}">
            </div>

            <div class="form-group">
                <input type="hidden" name="request_type" value="{{ config('servicingSetup.request_type_contract') }}">
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
                <button class="btn btn-save" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection