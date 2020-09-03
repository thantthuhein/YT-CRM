@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                </ul>
        	</div>
        @endif
    </div>
</div>

<div class="card content-card" style="height: auto">
    <div class="card-header">
        Choose quotation or enquiry to make Sale Contract
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('admin.sale-contracts.choose-quotation-enquiry')}}">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input class="form-control" type="text" name="customer_name" id="customer_name" >
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input class="form-control" type="number" name="phone_number" id="phone_number">
            </div>

            <div class="form-group">
                <button class="btn btn-save" type="button" id="search-btn" onclick="this.form.submit()">
                    {{ trans('global.search') }}
                </button>
            </div>
        </form>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
               
                <a class="nav-item nav-link active" id="enquiry-tab" data-toggle="tab" href="#enquiry-tab-content" role="tab" aria-selected="true">
                    Enquiry
                </a>
                <a class="nav-item nav-link" id="quotation-tab" data-toggle="tab" href="#quotation" role="tab" aria-selected="false">
                    Quotation
                </a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade active show" id="enquiry-tab-content" role="tabpanel" aria-labelledby="enquiry-tab">
                @include('admin.saleContracts.enquiry', ['enquiries' => $enquiries])
            </div>
            <div class="tab-pane fade" id="quotation" role="tabpanel" aria-labelledby="quotation-tab">
                @include('admin.saleContracts.quotation', ['quotations' => $quotations])
            </div>
        </div>
    </div>
</div>

@endsection