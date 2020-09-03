@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.servicingSetupRemark.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.servicing-setup-remarks.update", [$servicingSetupRemark->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{-- <div class="form-group">
                <label for="servicing_setup_id">{{ trans('cruds.servicingSetupRemark.fields.servicing_setup') }}</label>
                <select class="form-control select2 {{ $errors->has('servicing_setup') ? 'is-invalid' : '' }}" name="servicing_setup_id" id="servicing_setup_id">
                    @foreach($servicing_setups as $id => $servicing_setup)
                        <option value="{{ $id }}" {{ ($servicingSetupRemark->servicing_setup ? $servicingSetupRemark->servicing_setup->id : old('servicing_setup_id')) == $id ? 'selected' : '' }}>{{ $servicing_setup }}</option>
                    @endforeach
                </select>
                @if($errors->has('servicing_setup_id'))
                    <span class="text-danger">{{ $errors->first('servicing_setup_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingSetupRemark.fields.servicing_setup_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label for="remark">{{ trans('cruds.servicingSetupRemark.fields.remark') }}</label>
                <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark', $servicingSetupRemark->remark) !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicingSetupRemark.fields.remark_helper') }}</span>
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