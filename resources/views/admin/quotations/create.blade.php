@extends('layouts.admin')
@section('content')

@can('quotation_create')
<div class="card content-card">
    <div class="card-header enquiry-create">
        {{ trans('global.create') }} {{ trans('cruds.quotation.title_singular') }}
    </div>

    
    <div class="card-body">

        <div class="container pl-0">
            
            <div class="row">
                <div class="col-6">
                    <p class="font-weight-bold">Customer Informations</p>
                    <p>Customer Name - {{ $enquiry->customer->name }}</p>
                    <p>Email - {{ $enquiry->customer->email }}</p>
                    <p>Address - {{ $enquiry->customer->address }}</p>
                </div>
                <div class="col-6">
                    <p class="font-weight-bold">Enquiry Informations</p>
                    <p>Company Name - {{ $enquiry->company->name ?? "" }}</p>
                    <p>Project Name - {{ $enquiry->project->name ?? ""}}</p>
                    <p>Project Location - {{ $enquiry->location ?? "" }}</p>
                    <p>Enquiry Status - {{ $enquiry->status }}</p>
                </div>
            </div>
        </div>

        <hr>

        <form method="POST" action="{{ route("admin.quotations.store") }}" enctype="multipart/form-data" onsubmit="loadSpinner()">
            @csrf
            
            <div class="form-row form-group">
                
                <div class="col">

                    <label for="quotation_number_type">{{ trans('cruds.quotation.fields.quotation_number_type') }}</label>
                    
                    <select class="form-control select2" name="quotation_number_type" id="quotation_number_type">
                        
                        <option value disabled {{ old('quotation_number_type', null) === null ? 'selected' : '' }}>Please Select</option>
                        @foreach (config('quotations.quotation_types') as $key => $value)
                        <option value="{{ $value }}" {{ old('quotation_number_type', '') === (string) $value ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                        
                    </select>
                    @if($errors->has('quotation_number_type'))
                        <span class="text-danger">{{ $errors->first('quotation_number_type') }}</span>
                    @endif

                </div>

                <div class="col">

                    <label for="number">{{ trans('cruds.quotation.fields.number') }}</label>
                    <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="text" name="number" id="number" value="{{ old('number', '') }}">
                    @if($errors->has('number'))
                        <span class="text-danger">{{ $errors->first('number') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.quotation.fields.number_helper') }}</span>

                </div>

                <div class="col">

                    <label for="year">{{ trans('cruds.quotation.fields.year') }}</label>
                    <input class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" type="text" name="year" id="year" value="{{ old('year', now()->year) }}">
                    @if($errors->has('year'))
                        <span class="text-danger">{{ $errors->first('year') }}</span>
                    @endif

                </div>
                
            </div>

            <div class="form-group">
                <label for="customer_address">{{ trans('cruds.quotation.fields.customer_address') }}</label>

                <textarea class="form-control {{ $errors->has('customer_address') ? 'is-invalid' : '' }}" type="text" rows="1" name="customer_address" id="customer_address">{{ old('customer_address', $enquiry->customer->address) }}</textarea>

                @if($errors->has('customer_address'))
                    <span class="text-danger">{{ $errors->first('customer_address') }}</span>
                @endif
                
                <span class="help-block">{{ trans('cruds.quotation.fields.customer_address_helper') }}</span>
            </div>

            {{-- <div class="form-group">
                <label for="quotation_number">{{ trans('cruds.quotation.fields.iteration_number') }}</label>
                <input class="form-control {{ $errors->has('quotation_number') ? 'is-invalid' : '' }}" type="text" name="quotation_number" id="quotation_number" value="{{ old('quotation_number', '') }}">
                @if($errors->has('quotation_number'))
                    <span class="text-danger">{{ $errors->first('quotation_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotation.fields.customer_address_helper') }}</span>
            </div> --}}

    

            <div class="form-group">
                <label for="status">{{ trans('cruds.quotation.fields.status') }}</label>

                <select class="status-input input-color form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}></option>
                    @foreach(App\Quotation::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'pending') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.enquiry.fields.status_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="quoted_date">{{ trans('cruds.quotation.fields.quoted_date') }}</label>
                <input class="form-control date {{ $errors->has('quoted_date') ? 'is-invalid' : '' }}" type="text" name="quoted_date" id="quoted_date" value="{{ old('quoted_date') }}">
                @if($errors->has('quoted_date'))
                    <span class="text-danger">{{ $errors->first('quoted_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotation.fields.quoted_date_helper') }}</span>
            </div>

            <div class="form-group">
                <input type="hidden" name="customer_id" value="{{ $enquiry->customer->id }}">
            </div>

            <div class="form-group">
                <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
            </div>

            <div class="form-group">

                <label for="quotation_pdf">Upload PDF</label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input accept="application/pdf" name="quotation_pdf" type="file" class="custom-file-input {{ $errors->has('quotation_pdf') ? 'is-invalid' : '' }}" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>

                @if($errors->has('quotation_pdf'))
                    <span class="text-danger">{{ $errors->first('quotation_pdf') }}</span>
                @endif

                <span class="help-block">{{ trans('cruds.quotationRevision.fields.quotation_pdf_helper') }}</span>

            </div>  

            <div class="form-group">
                <button class="btn btn-save" type="submit" id="store-quotation">
                    {{ trans('global.save') }} 
                </button>

                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-cancel">
                    {{ trans('global.cancel') }} 
                </a>
            </div>

        </form>


    </div>
</div>
@endcan

@endsection

@section('scripts')
    <script>
        let storeQuotationButton = document.getElementById('store-quotation')

        function loadSpinner() {
            storeQuotationButton.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>';
        }

        $('#customFile').on('change',function(){
            let fileName = document.getElementById("customFile").files[0].name;
            
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection