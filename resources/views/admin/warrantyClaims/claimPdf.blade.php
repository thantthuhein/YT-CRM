<div class="card text-dark">
    <h5 class="card-header">
        Warranty Claim PDF
    </h5>
    <div class="card-body">
        <div class="form-group">
            <form action="{{ route("admin.warranty-claims.upload-pdf", [$warrantyClaim]) }}" method="POST" enctype="multipart/form-data" onsubmit="loadSpinner()">
                @csrf
                <div class="form-group">
                    <label for="warranty_claim_pdf">PDF</label>
                    <input class="form-control" type="file" id='warranty_claim_pdf' name="warranty_claim_pdf" accept="application/pdf" required>
                    @if($errors->has('warranty_claim_pdf'))
                        <span class="text-danger">{{ $errors->first('warranty_claim_pdf') }}</span>
                    @endif
                </div>
                <button id="upload-claim-pdf" class="btn btn-save" type="submit">
                    Upload
                </button>
            </form>
        </div>
    </div>
</div>
