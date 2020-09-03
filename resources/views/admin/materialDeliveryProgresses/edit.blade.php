@extends('layouts.admin')
@section('content')

@include('showErrors')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.materialDeliveryProgress.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.material-delivery-progresses.update", [$materialDeliveryProgress->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="progress">{{ trans('cruds.materialDeliveryProgress.fields.progress') }} ( between 0 and 100 )</label>
                <input class="form-control {{ $errors->has('progress') ? 'is-invalid' : '' }}" type="number" name="progress" id="progress" value="{{ old('progress', $materialDeliveryProgress->progress) }}" step="1">
                @if($errors->has('progress'))
                    <span class="text-danger">{{ $errors->first('progress') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.materialDeliveryProgress.fields.progress_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="">PDF(multiple)</label>
                <div class='form-group' style="display: flex;">
                    @foreach($materialDeliveryProgress->material_delivery_pdfs as $key => $pdf)
                        <span class="mr-2 p-1" style="display: block; border: 1px solid #ced4da; border-radius: 5px;">
                            File {{ ++$key }} : <a href="{{ $pdf->pdf }}" target="_blank">View</a>
                        </span>
                    @endforeach
                </div>
                <div class="form-check mb-2">
                    <input type='checkbox' name="remove" class='form-check-input' {{ old('remove') ? 'checked' : ''}}>
                    <label for="" class='form-check-label'>Remove and replace with the uploaded file</label>
                </div>
                <input type="file" class='form-control {{ $errors->has('material_pdf') ? 'is-invalid' : '' }}' name="material_pdf[]" multiple accept="application/pdf">
                {{-- <span class='small-text text-danger'> Uploading new file(s) will be replaced with the existing uploaded file(s).</span> --}}
                @if($errors->has('material_pdf'))
                    <span class="text-danger">{{ $errors->first('material_pdf') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="delivered_at">Delivered at</label>
                <input class="form-control date {{ $errors->has('delivered_at') ? 'is-invalid' : '' }}" type="text" name="delivered_at" id="delivered_at" value="{{ old('delivered_at', $materialDeliveryProgress->delivered_at) }}">
                @if($errors->has('delivered_at'))
                    <span class="text-danger">{{ $errors->first('delivered_at') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.materialDeliveryProgress.fields.remark') }}</label>
                {{-- <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark', $materialDeliveryProgress->remark) !!}</textarea> --}}
                <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark', $materialDeliveryProgress->remark) !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.materialDeliveryProgress.fields.remark_helper') }}</span>
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