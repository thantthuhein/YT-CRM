@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        Rate {{ trans('cruds.subComInstallation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sub-com-installations.update", [$subComInstallation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="rating">{{ trans('cruds.subComInstallation.fields.rating') }} ( 1 to 5 )</label>
                <input class="form-control {{ $errors->has('rating') ? 'is-invalid' : '' }}" type="number" name="rating" id="rating" value="{{ old('rating', $subComInstallation->rating) }}" step="1">
                @if($errors->has('rating'))
                    <span class="text-danger">{{ $errors->first('rating') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComInstallation.fields.rating_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="completed_month">{{ trans('cruds.subComInstallation.fields.completed_month') }}</label>
                <input class="form-control month-picker current-month {{ $errors->has('completed_month') ? 'is-invalid' : '' }}" type="number" name="completed_month" id="completed_month" value="{{ old('completed_month', $subComInstallation->completed_month) }}">
                @if($errors->has('completed_month'))
                    <span class="text-danger">{{ $errors->first('completed_month') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComInstallation.fields.completed_month_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="completed_year">{{ trans('cruds.subComInstallation.fields.completed_year') }}</label>
                <input class="form-control year-picker current-year {{ $errors->has('completed_year') ? 'is-invalid' : '' }}" type="number" name="completed_year" id="completed_year" value="{{ old('completed_year', $subComInstallation->completed_year) }}">
                @if($errors->has('completed_year'))
                    <span class="text-danger">{{ $errors->first('completed_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subComInstallation.fields.completed_year_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    {{ trans('global.save') }}
                </button>
                <a class="btn btn-cancel" href="{{ route('admin.sale-contracts.show', [$subComInstallation->sale_contract]) }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>


    </div>
</div>
@endsection