@extends('layouts.admin')
@section('content')

<div class="mb-2" style="margin-left:30px;">
    
</div>

<div class="card content-card">
    <div class="card-header">
        Upload New PDF
    </div>

    <div class="card-body">
        <div class="container pl-0">
            
            <div class="form-group">
                <label for="warranty_claim_pdf">Replace PDF</label>
                <form action="{{ route("admin.warranty-claims.upload-pdf", [$warrantyClaim]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" type="file" id='warranty_claim_pdf' name="warranty_claim_pdf" accept="application/pdf" required>
                        @if($errors->has('warranty_claim_pdf'))
                            <span class="text-danger">{{ $errors->first('warranty_claim_pdf') }}</span>
                        @endif
                    </div>
                    <button class="btn btn-sm btn-primary" type="submit">
                        Upload
                    </button>
                </form>
            </div>            
            
        </div>


    </div>
</div>
@endsection