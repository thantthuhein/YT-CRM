@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.handOverPdf.title_singular') }}
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route("admin.in-house-installations.hand-over-pdfs.store", [$inHouseInstallation]) }}" enctype="multipart/form-data" onsubmit="loadSpinner()">
            @csrf
            
            @include('admin.inHouseInstallations.afterCompleted.handoverPdfs', ['handoverPdfs' => $handoverPdfTypes])

            <div class="form-group">
                <button class="btn btn-save" type="submit" id="inhouse-upload-handover-pdfs">
                    {{ trans('global.save') }}
                </button>
                <a class="btn btn-default" href="{{ route('admin.in-house-installations.show', [$inHouseInstallation]) }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    @stack('js')
    <script>
        let inhouseUploadHandoverPdf = document.getElementById('inhouse-upload-handover-pdfs')

        function loadSpinner() {
            inhouseUploadHandoverPdf.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>';
        }
    </script>
@endsection