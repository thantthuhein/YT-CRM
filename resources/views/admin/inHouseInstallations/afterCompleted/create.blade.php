@extends('layouts.admin')
@section('content')

<div style="margin: 0 30px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
    @endif
</div>

<div class="card content-card">
    <div class="card-header">
        Upload Necessary Data
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.sale-contracts.inhouseInstallation.addCompletedData', [$saleContract, $saleContract->inHouseInstallation]) }}" enctype="multipart/form-data" onsubmit="loadSpinner()">
            @csrf
            <div class="form-group">
                <label for="tc_time">{{ trans('cruds.inHouseInstallation.fields.tc_time') }}</label>
                <input class="form-control date {{ $errors->has('tc_time') ? 'is-invalid' : '' }}" type="text" name="tc_time" id="tc_time" value="{{ old('tc_time') }}" required>
                @if($errors->has('tc_time'))
                    <span class="text-danger">{{ $errors->first('tc_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.tc_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hand_over_date">{{ trans('cruds.inHouseInstallation.fields.hand_over_date') }}</label>
                <input class="form-control date {{ $errors->has('hand_over_date') ? 'is-invalid' : '' }}" type="text" name="hand_over_date" id="hand_over_date" value="{{ old('hand_over_date') }}" required>
                @if($errors->has('hand_over_date'))
                    <span class="text-danger">{{ $errors->first('hand_over_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.hand_over_date_helper') }}</span>
            </div>

            @include('admin.inHouseInstallations.afterCompleted.handoverPdfs', ['handoverPdfs' => $handoverPdfTypes])

            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    Upload
                </button>
                <a class="btn btn-cancel" href="{{ route('admin.in-house-installations.show', [$saleContract->inHouseInstallation]) }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    @stack('js')
    <script>
    
    </script>
@endsection