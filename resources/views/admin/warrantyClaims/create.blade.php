@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.warrantyClaim.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.warranty-claims.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="oncall_id">{{ trans('cruds.warrantyClaim.fields.oncall') }}</label>
                <select class="form-control select2 {{ $errors->has('oncall') ? 'is-invalid' : '' }}" name="oncall_id" id="oncall_id">
                    @foreach($oncalls as $id => $oncall)
                        <option value="{{ $id }}" {{ old('oncall_id') == $id ? 'selected' : '' }}>{{ $oncall }}</option>
                    @endforeach
                </select>
                @if($errors->has('oncall_id'))
                    <span class="text-danger">{{ $errors->first('oncall_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.oncall_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="warranty_claim_validation_id">{{ trans('cruds.warrantyClaim.fields.warranty_claim_validation') }}</label>
                <select class="form-control select2 {{ $errors->has('warranty_claim_validation') ? 'is-invalid' : '' }}" name="warranty_claim_validation_id" id="warranty_claim_validation_id">
                    @foreach($warranty_claim_validations as $id => $warranty_claim_validation)
                        <option value="{{ $id }}" {{ old('warranty_claim_validation_id') == $id ? 'selected' : '' }}>{{ $warranty_claim_validation }}</option>
                    @endforeach
                </select>
                @if($errors->has('warranty_claim_validation_id'))
                    <span class="text-danger">{{ $errors->first('warranty_claim_validation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.warranty_claim_validation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="warranty_claim_action_id">{{ trans('cruds.warrantyClaim.fields.warranty_claim_action') }}</label>
                <select class="form-control select2 {{ $errors->has('warranty_claim_action') ? 'is-invalid' : '' }}" name="warranty_claim_action_id" id="warranty_claim_action_id">
                    @foreach($warranty_claim_actions as $id => $warranty_claim_action)
                        <option value="{{ $id }}" {{ old('warranty_claim_action_id') == $id ? 'selected' : '' }}>{{ $warranty_claim_action }}</option>
                    @endforeach
                </select>
                @if($errors->has('warranty_claim_action_id'))
                    <span class="text-danger">{{ $errors->first('warranty_claim_action_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.warranty_claim_action_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="warranty_claim_pdf">{{ trans('cruds.warrantyClaim.fields.warranty_claim_pdf') }}</label>
                <div class="needsclick dropzone {{ $errors->has('warranty_claim_pdf') ? 'is-invalid' : '' }}" id="warranty_claim_pdf-dropzone">
                </div>
                @if($errors->has('warranty_claim_pdf'))
                    <span class="text-danger">{{ $errors->first('warranty_claim_pdf') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.warranty_claim_pdf_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.warrantyClaim.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.warrantyClaim.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\WarrantyClaim::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'pending') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.warrantyClaim.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.warrantyClaim.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ old('updated_by_id') == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.updated_by_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.warrantyClaimPdfDropzone = {
    url: '{{ route('admin.warranty-claims.storeMedia') }}',
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
      $('form').find('input[name="warranty_claim_pdf"]').remove()
      $('form').append('<input type="hidden" name="warranty_claim_pdf" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="warranty_claim_pdf"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($warrantyClaim) && $warrantyClaim->warranty_claim_pdf)
      var file = {!! json_encode($warrantyClaim->warranty_claim_pdf) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="warranty_claim_pdf" value="' + file.file_name + '">')
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