@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.equipmentDeliverySchedule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.equipment-delivery-schedules.update", [$equipmentDeliverySchedule->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            
            <div class="form-group">
                <label for="description">{{ trans('cruds.equipmentDeliverySchedule.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $equipmentDeliverySchedule->description) !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.equipmentDeliverySchedule.fields.description_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="delivered_at">{{ trans('cruds.equipmentDeliverySchedule.fields.delivered_at') }}</label>
                <input class="form-control date {{ $errors->has('delivered_at') ? 'is-invalid' : '' }}" type="text" name="delivered_at" id="delivered_at" value="{{ old('delivered_at', $equipmentDeliverySchedule->delivered_at) }}">
                @if($errors->has('delivered_at'))
                    <span class="text-danger">{{ $errors->first('delivered_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.equipmentDeliverySchedule.fields.delivered_at_helper') }}</span>
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