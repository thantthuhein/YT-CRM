@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.repair.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.repairs.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="oncall_id">{{ trans('cruds.repair.fields.oncall') }}</label>
                <select class="form-control select2 {{ $errors->has('oncall') ? 'is-invalid' : '' }}" name="oncall_id" id="oncall_id">
                    @foreach($oncalls as $id => $oncall)
                        <option value="{{ $id }}" {{ old('oncall_id') == $id ? 'selected' : '' }}>{{ $oncall }}</option>
                    @endforeach
                </select>
                @if($errors->has('oncall_id'))
                    <span class="text-danger">{{ $errors->first('oncall_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repair.fields.oncall_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="estimate_date">{{ trans('cruds.repair.fields.estimate_date') }}</label>
                <input class="form-control date {{ $errors->has('estimate_date') ? 'is-invalid' : '' }}" type="text" name="estimate_date" id="estimate_date" value="{{ old('estimate_date') }}">
                @if($errors->has('estimate_date'))
                    <span class="text-danger">{{ $errors->first('estimate_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repair.fields.estimate_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="actual_date">{{ trans('cruds.repair.fields.actual_date') }}</label>
                <input class="form-control date {{ $errors->has('actual_date') ? 'is-invalid' : '' }}" type="text" name="actual_date" id="actual_date" value="{{ old('actual_date') }}">
                @if($errors->has('actual_date'))
                    <span class="text-danger">{{ $errors->first('actual_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repair.fields.actual_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.repair.fields.has_spare_part_replacement') }}</label>
                @foreach(App\Repair::HAS_SPARE_PART_REPLACEMENT_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('has_spare_part_replacement') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="has_spare_part_replacement_{{ $key }}" name="has_spare_part_replacement" value="{{ $key }}" {{ old('has_spare_part_replacement', '') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="has_spare_part_replacement_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('has_spare_part_replacement'))
                    <span class="text-danger">{{ $errors->first('has_spare_part_replacement') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repair.fields.has_spare_part_replacement_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="service_report_pdf">{{ trans('cruds.repair.fields.service_report_pdf') }}</label>
                <div class="needsclick dropzone {{ $errors->has('service_report_pdf') ? 'is-invalid' : '' }}" id="service_report_pdf-dropzone">
                </div>
                @if($errors->has('service_report_pdf'))
                    <span class="text-danger">{{ $errors->first('service_report_pdf') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repair.fields.service_report_pdf_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.repair.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repair.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.repair.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ old('updated_by_id') == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repair.fields.updated_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.repair.fields.team_type') }}</label>
                <select class="form-control {{ $errors->has('team_type') ? 'is-invalid' : '' }}" name="team_type" id="team_type">
                    <option value disabled {{ old('team_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Repair::TEAM_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('team_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('team_type'))
                    <span class="text-danger">{{ $errors->first('team_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.repair.fields.team_type_helper') }}</span>
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
    Dropzone.options.serviceReportPdfDropzone = {
    url: '{{ route('admin.repairs.storeMedia') }}',
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
      $('form').find('input[name="service_report_pdf"]').remove()
      $('form').append('<input type="hidden" name="service_report_pdf" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="service_report_pdf"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($repair) && $repair->service_report_pdf)
      var file = {!! json_encode($repair->service_report_pdf) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="service_report_pdf" value="' + file.file_name + '">')
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