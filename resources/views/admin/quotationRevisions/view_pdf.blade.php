@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
      <p>Quotation PDF</p>
    </div>

    <div class="card-body" style="height:400px;">
      <div class="text-center">
        <a href="{{$quotationRevision->quotation_pdf}}" 
          target="_blank" 
          class="btn mr-5 rounded-pill bg-success"> 
          <i class="fas fa-eye"></i> 
          View PDF 
        </a>
        
        <a href="{{url('/admin/quotation-revisions/download_pdf', $quotationRevision->id)}}" 
          target="_blank"
          class="btn rounded-pill bg-dark"> 
          
          <i class="fas fa-cloud-download-alt"></i> 
          Download PDF 

        </a>
      </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

</script>    
@endsection