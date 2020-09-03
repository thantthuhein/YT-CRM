@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.repairRemark.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.repair-remarks.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="repair_id">{{ trans('cruds.repairRemark.fields.repair') }}</label>
                <select class="form-control select2 {{ $errors->has('repair') ? 'is-invalid' : '' }}" name="repair_id" id="repair_id">
                    @foreach($repairs as $id => $repair)
                        <option value="{{ $id }}" {{ old('repair_id') == $id ? 'selected' : '' }}>{{ $repair }}</option>
                    @endforeach
                </select>
                @if($errors->has('repair_id'))
                    <span class="text-danger">{{ $errors->first('repair_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repairRemark.fields.repair_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.repairRemark.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repairRemark.fields.remark_helper') }}</span>
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