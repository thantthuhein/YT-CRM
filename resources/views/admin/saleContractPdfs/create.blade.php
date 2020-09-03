@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.saleContractPdf.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sale-contract-pdfs.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="sale_contract_id">{{ trans('cruds.saleContractPdf.fields.sale_contract') }}</label>
                <select class="form-control select2 {{ $errors->has('sale_contract') ? 'is-invalid' : '' }}" name="sale_contract_id" id="sale_contract_id">
                    @foreach($sale_contracts as $id => $sale_contract)
                        <option value="{{ $id }}" {{ old('sale_contract_id') == $id ? 'selected' : '' }}>{{ $sale_contract }}</option>
                    @endforeach
                </select>
                @if($errors->has('sale_contract_id'))
                    <span class="text-danger">{{ $errors->first('sale_contract_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContractPdf.fields.sale_contract_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="iteration">{{ trans('cruds.saleContractPdf.fields.iteration') }}</label>
                <input class="form-control {{ $errors->has('iteration') ? 'is-invalid' : '' }}" type="number" name="iteration" id="iteration" value="{{ old('iteration') }}" step="1">
                @if($errors->has('iteration'))
                    <span class="text-danger">{{ $errors->first('iteration') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContractPdf.fields.iteration_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="url">{{ trans('cruds.saleContractPdf.fields.url') }}</label>
                <div class="needsclick dropzone {{ $errors->has('url') ? 'is-invalid' : '' }}" id="url-dropzone">
                </div>
                @if($errors->has('url'))
                    <span class="text-danger">{{ $errors->first('url') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContractPdf.fields.url_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title">{{ trans('cruds.saleContractPdf.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}">
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContractPdf.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="uploaded_by_id">{{ trans('cruds.saleContractPdf.fields.uploaded_by') }}</label>
                <select class="form-control select2 {{ $errors->has('uploaded_by') ? 'is-invalid' : '' }}" name="uploaded_by_id" id="uploaded_by_id">
                    @foreach($uploaded_bies as $id => $uploaded_by)
                        <option value="{{ $id }}" {{ old('uploaded_by_id') == $id ? 'selected' : '' }}>{{ $uploaded_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('uploaded_by_id'))
                    <span class="text-danger">{{ $errors->first('uploaded_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContractPdf.fields.uploaded_by_helper') }}</span>
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
    url: '{{ route('admin.sale-contract-pdfs.storeMedia') }}',
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
@if(isset($saleContractPdf) && $saleContractPdf->url)
      var file = {!! json_encode($saleContractPdf->url) !!}
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