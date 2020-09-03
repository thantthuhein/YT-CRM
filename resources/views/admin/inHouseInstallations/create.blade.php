@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header d-flex">
        <p>{{ trans('global.create') }} {{ trans('cruds.inHouseInstallation.title_singular') }}</p>
        <div class="ml-auto">
            <a href="{{ route('admin.sale-contracts.show', request()->query('sale-contract-id')) }}" class="btn btn-save btn-sm">Go To Sales Contract</a>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.in-house-installations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="site_engineer_id">{{ trans('cruds.inHouseInstallation.fields.site_engineer') }}</label>
                <select class="form-control select2 {{ $errors->has('site_engineer') ? 'is-invalid' : '' }}" name="site_engineer_id" id="site_engineer_id">
                    @foreach($site_engineers as $id => $site_engineer)
                        <option value="{{ $id }}" {{ old('site_engineer_id') == $id ? 'selected' : '' }}>{{ $site_engineer }}</option>
                    @endforeach
                </select>
                @if($errors->has('site_engineer_id'))
                    <span class="text-danger">{{ $errors->first('site_engineer_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.site_engineer_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="servicing_team_id">{{ trans('cruds.inhouseInstallationTeam.fields.servicing_team') }}</label>
                <select class="form-control select2 {{ $errors->has('servicing_team') ? 'is-invalid' : '' }}" name="servicing_team_id[]" id="servicing_team_id" multiple>
                    <option value="" disabled>Please select</option>
                    @foreach($servicing_teams as $id => $servicing_team)
                        <option value="{{ $id }}" {{ in_array($id, old('servicing_team_id', [])) ? 'selected' : '' }}>{{ $servicing_team }}</option>
                    @endforeach
                </select>
                @if($errors->has('servicing_team_id'))
                    <span class="text-danger">{{ $errors->first('servicing_team_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inhouseInstallationTeam.fields.servicing_team_helper') }}</span>
            </div>

            @if(request()->query('sale-contract-id'))
                <input type="hidden" value="{{ request()->query('sale-contract-id') }}" name="sale_contract_id">
            @else
                <div class="form-group">
                    <label for="sale_contract_id">{{ trans('cruds.inHouseInstallation.fields.sale_contract') }}</label>
                    <select class="form-control select2 {{ $errors->has('sale_contract') ? 'is-invalid' : '' }}" name="sale_contract_id" id="sale_contract_id">
                        @foreach($sale_contracts as $id => $sale_contract)
                            <option value="{{ $id }}" {{ old('sale_contract_id', request()->query('sale-contract-id')) == $id ? 'selected' : '' }}>{{ $sale_contract }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('sale_contract_id'))
                        <span class="text-danger">{{ $errors->first('sale_contract_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.sale_contract_helper') }}</span>
                </div>
            @endif

            {{-- <div class="form-group">
                <label for="sale_contract_id">{{ trans('cruds.inHouseInstallation.fields.sale_contract') }}</label>
                <select class="form-control select2 {{ $errors->has('sale_contract') ? 'is-invalid' : '' }}" name="sale_contract_id" id="sale_contract_id">
                    @foreach($sale_contracts as $id => $sale_contract)
                        <option value="{{ $id }}" {{ old('sale_contract_id', request()->query('sale-contract-id')) == $id ? 'selected' : '' }}>{{ $sale_contract }}</option>
                    @endforeach
                </select>
                @if($errors->has('sale_contract_id'))
                    <span class="text-danger">{{ $errors->first('sale_contract_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.sale_contract_helper') }}</span>
            </div> --}}

            <div class="form-group">
                <label class="required" for="estimate_start_date">{{ trans('cruds.inHouseInstallation.fields.estimate_start_date') }}</label>
                <input class="form-control date {{ $errors->has('estimate_start_date') ? 'is-invalid' : '' }}" type="text" name="estimate_start_date" id="estimate_start_date" value="{{ old('estimate_start_date') }}" required>
                @if($errors->has('estimate_start_date'))
                    <span class="text-danger">{{ $errors->first('estimate_start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.estimate_start_date_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="estimate_end_date">{{ trans('cruds.inHouseInstallation.fields.estimate_end_date') }}</label>
                <input class="form-control date {{ $errors->has('estimate_end_date') ? 'is-invalid' : '' }}" type="text" name="estimate_end_date" id="estimate_end_date" value="{{ old('estimate_end_date') }}" required>
                @if($errors->has('estimate_end_date'))
                    <span class="text-danger">{{ $errors->first('estimate_end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.estimate_end_date_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="actual_start_date">{{ trans('cruds.inHouseInstallation.fields.actual_start_date') }}</label>
                <input class="form-control date {{ $errors->has('actual_start_date') ? 'is-invalid' : '' }}" type="text" name="actual_start_date" id="actual_start_date" value="{{ old('actual_start_date') }}">
                @if($errors->has('actual_start_date'))
                    <span class="text-danger">{{ $errors->first('actual_start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.actual_start_date_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="actual_end_date">{{ trans('cruds.inHouseInstallation.fields.actual_end_date') }}</label>
                <input class="form-control date {{ $errors->has('actual_end_date') ? 'is-invalid' : '' }}" type="text" name="actual_end_date" id="actual_end_date" value="{{ old('actual_end_date') }}">
                @if($errors->has('actual_end_date'))
                    <span class="text-danger">{{ $errors->first('actual_end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.actual_end_date_helper') }}</span>
            </div>

            {{-- <div class="form-group">
                <label for="tc_time">{{ trans('cruds.inHouseInstallation.fields.tc_time') }}</label>
                <input class="form-control date {{ $errors->has('tc_time') ? 'is-invalid' : '' }}" type="text" name="tc_time" id="tc_time" value="{{ old('tc_time') }}">
                @if($errors->has('tc_time'))
                    <span class="text-danger">{{ $errors->first('tc_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.tc_time_helper') }}</span>
            </div> --}}
            {{-- <div class="form-group">
                <label for="hand_over_date">{{ trans('cruds.inHouseInstallation.fields.hand_over_date') }}</label>
                <input class="form-control date {{ $errors->has('hand_over_date') ? 'is-invalid' : '' }}" type="text" name="hand_over_date" id="hand_over_date" value="{{ old('hand_over_date') }}">
                @if($errors->has('hand_over_date'))
                    <span class="text-danger">{{ $errors->first('hand_over_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.hand_over_date_helper') }}</span>
            </div> --}}
            {{-- <div class="form-group">
                <label for="actual_installation_report_pdf">{{ trans('cruds.inHouseInstallation.fields.actual_installation_report_pdf') }}</label>
                <div class="needsclick dropzone {{ $errors->has('actual_installation_report_pdf') ? 'is-invalid' : '' }}" id="actual_installation_report_pdf-dropzone">
                </div>
                @if($errors->has('actual_installation_report_pdf'))
                    <span class="text-danger">{{ $errors->first('actual_installation_report_pdf') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.actual_installation_report_pdf_helper') }}</span>
            </div> --}}
            {{-- <div class="form-group">
                <label for="service_manager_approve_date">{{ trans('cruds.inHouseInstallation.fields.service_manager_approve_date') }}</label>
                <input class="form-control date {{ $errors->has('service_manager_approve_date') ? 'is-invalid' : '' }}" type="text" name="service_manager_approve_date" id="service_manager_approve_date" value="{{ old('service_manager_approve_date') }}">
                @if($errors->has('service_manager_approve_date'))
                    <span class="text-danger">{{ $errors->first('service_manager_approve_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.service_manager_approve_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="approved_service_manager_id">{{ trans('cruds.inHouseInstallation.fields.approved_service_manager') }}</label>
                <select class="form-control select2 {{ $errors->has('approved_service_manager') ? 'is-invalid' : '' }}" name="approved_service_manager_id" id="approved_service_manager_id">
                    @foreach($approved_service_managers as $id => $approved_service_manager)
                        <option value="{{ $id }}" {{ old('approved_service_manager_id') == $id ? 'selected' : '' }}>{{ $approved_service_manager }}</option>
                    @endforeach
                </select>
                @if($errors->has('approved_service_manager_id'))
                    <span class="text-danger">{{ $errors->first('approved_service_manager_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.approved_service_manager_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_manager_approve_date">{{ trans('cruds.inHouseInstallation.fields.project_manager_approve_date') }}</label>
                <input class="form-control date {{ $errors->has('project_manager_approve_date') ? 'is-invalid' : '' }}" type="text" name="project_manager_approve_date" id="project_manager_approve_date" value="{{ old('project_manager_approve_date') }}">
                @if($errors->has('project_manager_approve_date'))
                    <span class="text-danger">{{ $errors->first('project_manager_approve_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.project_manager_approve_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="approved_project_manager_id">{{ trans('cruds.inHouseInstallation.fields.approved_project_manager') }}</label>
                <select class="form-control select2 {{ $errors->has('approved_project_manager') ? 'is-invalid' : '' }}" name="approved_project_manager_id" id="approved_project_manager_id">
                    @foreach($approved_project_managers as $id => $approved_project_manager)
                        <option value="{{ $id }}" {{ old('approved_project_manager_id') == $id ? 'selected' : '' }}>{{ $approved_project_manager }}</option>
                    @endforeach
                </select>
                @if($errors->has('approved_project_manager_id'))
                    <span class="text-danger">{{ $errors->first('approved_project_manager_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.approved_project_manager_helper') }}</span>
            </div> --}}
            
            <div class="form-group">
                <label>{{ trans('cruds.inHouseInstallation.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\InHouseInstallation::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'pending') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.status_helper') }}</span>
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
    Dropzone.options.actualInstallationReportPdfDropzone = {
    url: '{{ route('admin.in-house-installations.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="actual_installation_report_pdf"]').remove()
      $('form').append('<input type="hidden" name="actual_installation_report_pdf" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="actual_installation_report_pdf"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($inHouseInstallation) && $inHouseInstallation->actual_installation_report_pdf)
      var file = {!! json_encode($inHouseInstallation->actual_installation_report_pdf) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="actual_installation_report_pdf" value="' + file.file_name + '">')
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