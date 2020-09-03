@extends('layouts.admin')
@section('styles')
    <style>
        .payment-wrapper div:nth-of-type(odd){
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection
@section('content')

<div class="content-card card display-card text-white">
    <div class="card-header">
        Make Payment
    </div>

    
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    {!! implode('', $errors->all('<li class="error list-item">:message</li>')) !!}
                </ul>
            </div>
        @endif
        <div class="form-group">

            @include('admin.saleContracts.infoTable')
                
        </div>
        
        @include('admin.saleContracts.paymentSteps')

    </div>
</div>
@endsection

@section('scripts')
    <script>
        let paymentStepUploadInvoiceBtn = document.getElementById('payment-step-upload-invoice')                

        function loadPaymentStepSpinner() {
            paymentStepUploadInvoiceBtn.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>';
        }

        $('#customFile').on('change',function(){
            let fileName = document.getElementById("customFile").files[0].name;
            
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection