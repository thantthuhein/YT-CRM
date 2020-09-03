@extends('layouts.admin')
@section('content')

@can('upload_other_docs_access')
<div style="margin:0 30px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                {!! implode('', $errors->all('<li class="error list-item">:message</li>')) !!}
            </ul>
        </div>
    @endif
</div>

<div class="card content-card" style="height: auto">
    <div class="card-header d-flex">        
        <p>Others Documents for Service Manager</p>
        <div class="ml-auto">
            <a href="{{ route('admin.sale-contracts.show', $saleContract->id) }}" class="btn btn-sm btn-save">Back To Sales Contract</a>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sale-contracts.upload-other-documents", [$saleContract]) }}" enctype="multipart/form-data" onsubmit="loadSpinner()">
            @csrf
            <div class="form-group">
                <label for="iteration">Revised - {{ $saleContract->nextIteration() }}</label>
                {{-- <input type=number name="iteration" id="iteration" min='1' class='form-control' value="{{ $saleContract->nextIteration() }}"> --}}
                {{-- @if($errors->has('iteration'))
                    <span class="text-danger">{{ $errors->first('iteration') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.installation_type_helper') }}</span> --}}
            </div>
            
            <div id="multiple-pdfs-container">
                @foreach($withInstallationTitles as $key => $title)
                    <div class="pdf-upload-wrapper">
                        <div class="form-group">
                            <label for="pdf_title">{{ $title }}{{in_array($key, ['drawing', 'others']) ? "(multiple)" : "" }}</label>
                        </div>
                        <div class="form-group">
                            <label for="pdf">Upload PDF</label>
                            <input type=file name="{{ in_array($key, ['drawing', 'others']) ? 'pdfs['.$key.'][]' : 'pdfs['.$key.']' }}" class="form-control pdf-file" accept="application/pdf" {{ in_array($key, ['drawing', 'others']) ? 'multiple' : ""}}>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <button class="btn btn-save" type="submit" id="sale-contract-upload-docs">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endcan

@endsection

@section('scripts')
    <script>
        let saleContractUploadDocsButton = document.getElementById('sale-contract-upload-docs')
        
        function loadSpinner() {
            saleContractUploadDocsButton.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>';
        }
    </script>
@endsection