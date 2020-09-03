@extends('layouts.admin')
@section('content')

<div class="row" style="margin: 0 30px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
    @endif
</div>


<div class="card content-card mb-2">
    <h6 class="card-header">
        Upload Actual Installation Report PDF
    </h6>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.inhouseInstallation.uploadActualInstallationReport', [$inHouseInstallation]) }}" enctype="multipart/form-data" onsubmit="loadSpinner()">
            @csrf
            <div class="form-group">
                <label for="actual_installation_report_pdf" class="ml-3">
                    {{ trans('cruds.inHouseInstallation.fields.actual_installation_report_pdf') }}
                </label>                
                
                <input type=file name="actual_installation_report_pdf" class='form-control' accept="application/pdf" required>
                @if($errors->has('actual_installation_report_pdf'))
                    <span class="text-danger">{{ $errors->first('actual_installation_report_pdf') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inHouseInstallation.fields.actual_installation_report_pdf_helper') }}</span>
            </div>
            <button class="btn btn-save" type="submit" id="inhouse-installation-actual-installation-report-pdf">
                Upload
            </button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script>        
        let inhouseActualInstallationReport = document.getElementById('inhouse-installation-actual-installation-report-pdf')

        function loadSpinner() {
            inhouseActualInstallationReport.innerHTML = 'Uploading <i class="fas fa-spinner fa-spin"></i>';
        }
    </script>
@endsection