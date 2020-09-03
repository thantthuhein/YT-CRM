@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.quotationRevision.title_singular') }}
    </div>


    <div class="card-body">

        <div class="container pl-0">
            <div class="row">

                <div class="col-6">
                    <p>
                        Quotation Revision -
                        @if ( optional($quotationRevision)->quotation_revision === NULL )
                            First Quotation
                        @else                            
                            {{ $quotationRevision->quotation_revision }}
                        @endif 
                    </p>
                </div>

                <div class="col-6">
                    <p>
                        Quotation Number - {{$quotationRevision->quotation->number}}
                    </p>
                </div>

            </div>
        </div>

        <form onsubmit="loadSpinnerQuotationRevision()" method="POST" action="{{ route("admin.quotation-revisions.update", [$quotationRevision->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            {{-- quotation revision --}}
            {{-- <div class="form-group">
                <label class="required" for="quotation_revision">{{ trans('cruds.quotationRevision.fields.quotation_revision') }}</label>
                <input class="form-control {{ $errors->has('quotation_revision') ? 'is-invalid' : '' }}" type="text" name="quotation_revision" id="quotation_revision" value="{{ old('quotation_revision', $quotationRevision->quotation_revision) }}" required>
                @if($errors->has('quotation_revision'))
                    <span class="text-danger">{{ $errors->first('quotation_revision') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotationRevision.fields.quotation_revision_helper') }}</span>
            </div> --}}

            {{-- quotation number --}}
            {{-- <div class="form-group">
                <label for="quotation_id">{{ trans('cruds.quotationRevision.fields.quotation') }}</label>
                <select class="form-control select2 {{ $errors->has('quotation') ? 'is-invalid' : '' }}" name="quotation_id" id="quotation_id">
                    @foreach($quotations as $id => $quotation)
                        <option value="{{ $id }}" {{ ($quotationRevision->quotation ? $quotationRevision->quotation->id : old('quotation_id')) == $id ? 'selected' : '' }}>{{ $quotation }}</option>
                    @endforeach
                </select>
                @if($errors->has('quotation_id'))
                    <span class="text-danger">{{ $errors->first('quotation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotationRevision.fields.quotation_helper') }}</span>
            </div> --}}
            
            <div class="form-group">
                <label for="quoted_date">{{ trans('cruds.quotationRevision.fields.quoted_date') }}</label>
                <input class="form-control date {{ $errors->has('quoted_date') ? 'is-invalid' : '' }}" type="text" name="quoted_date" id="quoted_date" value="{{ old('quoted_date', $quotationRevision->quoted_date) }}">
                @if($errors->has('quoted_date'))
                    <span class="text-danger">{{ $errors->first('quoted_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotationRevision.fields.quoted_date_helper') }}</span>
            </div>

            <div class="form-group">
                {{-- <div class="needsclick dropzone {{ $errors->has('quotation_pdf') ? 'is-invalid' : '' }}" id="quotation_pdf-dropzone" name="quotation_pdf">
                </div> --}}
                <div class="form-group">
                    <label for="quotation_pdf">Upload PDF</label>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input accept="application/pdf" name="quotation_pdf" type="file" class="custom-file-input {{ $errors->has('quotation_pdf') ? 'is-invalid' : '' }}" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                @if($errors->has('quotation_pdf'))
                    <span class="text-danger">{{ $errors->first('quotation_pdf') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotationRevision.fields.quotation_pdf_helper') }}</span>
            </div>

            <div class="form-group">
                <label>{{ trans('cruds.quotationRevision.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\QuotationRevision::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $quotationRevision->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotationRevision.fields.status_helper') }}</span>
            </div>

            {{-- created by --}}
            {{-- <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.quotationRevision.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ ($quotationRevision->created_by ? $quotationRevision->created_by->id : old('created_by_id')) == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotationRevision.fields.created_by_helper') }}</span>
            </div> --}}

            {{-- updated by --}}
            {{-- <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.quotationRevision.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ ($quotationRevision->updated_by ? $quotationRevision->updated_by->id : old('updated_by_id')) == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotationRevision.fields.updated_by_helper') }}</span>
            </div> --}}

            <div class="form-group">
                <button class="btn btn-save" type="submit" id="quotation-revision-upload">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
    let btnQuotationrevision = document.getElementById('quotation-revision-upload')
    function loadSpinnerQuotationRevision() {
        btnQuotationrevision.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>'
    }

    $('#customFile').on('change',function(){
        let fileName = document.getElementById("customFile").files[0].name;
        
        $(this).next('.custom-file-label').html(fileName);
    });
    Dropzone.options.quotationPdfDropzone = {
    url: '{{ route('admin.quotation-revisions.storeMedia') }}',
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
      $('form').find('input[name="quotation_pdf"]').remove()
      $('form').append('<input type="hidden" name="quotation_pdf" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="quotation_pdf"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($quotationRevision) && $quotationRevision->quotation_pdf)
      var file = {!! json_encode($quotationRevision->quotation_pdf) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="quotation_pdf" value="' + file.file_name + '">')
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