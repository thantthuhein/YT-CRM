@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.handOverPdf.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.hand-over-pdfs.update", [$handOverPdf->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="inhouse_installation_id">{{ trans('cruds.handOverPdf.fields.inhouse_installation') }}</label>
                <select class="form-control select2 {{ $errors->has('inhouse_installation') ? 'is-invalid' : '' }}" name="inhouse_installation_id" id="inhouse_installation_id">
                    @foreach($inhouse_installations as $id => $inhouse_installation)
                        <option value="{{ $id }}" {{ ($handOverPdf->inhouse_installation ? $handOverPdf->inhouse_installation->id : old('inhouse_installation_id')) == $id ? 'selected' : '' }}>{{ $inhouse_installation }}</option>
                    @endforeach
                </select>
                @if($errors->has('inhouse_installation_id'))
                    <span class="text-danger">{{ $errors->first('inhouse_installation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.handOverPdf.fields.inhouse_installation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="url">{{ trans('cruds.handOverPdf.fields.url') }}</label>
                <div class="needsclick dropzone {{ $errors->has('url') ? 'is-invalid' : '' }}" id="url-dropzone">
                </div>
                @if($errors->has('url'))
                    <span class="text-danger">{{ $errors->first('url') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.handOverPdf.fields.url_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.handOverPdf.fields.file_type') }}</label>
                <select class="form-control {{ $errors->has('file_type') ? 'is-invalid' : '' }}" name="file_type" id="file_type">
                    <option value disabled {{ old('file_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\HandOverPdf::FILE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('file_type', $handOverPdf->file_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('file_type'))
                    <span class="text-danger">{{ $errors->first('file_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.handOverPdf.fields.file_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.handOverPdf.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $handOverPdf->description) !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.handOverPdf.fields.description_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.urlDropzone = {
    url: '{{ route('admin.hand-over-pdfs.storeMedia') }}',
    maxFilesize: 40, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 40
    },
    success: function (file, response) {
      $('form').find('input[name="url"]').remove()
      $('form').append('<input type="hidden" name="url" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="url"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($handOverPdf) && $handOverPdf->url)
      var file = {!! json_encode($handOverPdf->url) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="url" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection