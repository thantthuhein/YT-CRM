@extends('layouts.admin')
@section('content')

@can('quotation_edit')
<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.quotation.title_singular') }}
    </div>

    <div class="card-body">
        <form onsubmit="loadSpinQuotation()" method="POST" action="{{ route("admin.quotations.update", [$quotation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{-- <div class="form-group">
                <label for="customer_id">{{ trans('cruds.quotation.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id">
                    @foreach($customers as $id => $customer)
                        <option value="{{ $id }}" {{ ($quotation->customer ? $quotation->customer->id : old('customer_id')) == $id ? 'selected' : '' }}>{{ $customer }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer_id'))
                    <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotation.fields.customer_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="enquiries_id">{{ trans('cruds.quotation.fields.enquiries') }}</label>
                <select class="form-control select2 {{ $errors->has('enquiries') ? 'is-invalid' : '' }}" name="enquiries_id" id="enquiries_id">
                    @foreach($enquiries as $id => $enquiries)
                        <option value="{{ $id }}" {{ ($quotation->enquiries ? $quotation->enquiries->id : old('enquiries_id')) == $id ? 'selected' : '' }}>{{ $enquiries }}</option>
                    @endforeach
                </select>
                @if($errors->has('enquiries_id'))
                    <span class="text-danger">{{ $errors->first('enquiries_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotation.fields.enquiries_helper') }}</span>
            </div> --}}

            <div class="form-row form-group">
                
                <div class="col">

                    <label for="quotation_number_type">{{ trans('cruds.quotation.fields.quotation_number_type') }}</label>
                    
                    <select class="form-control select2" name="quotation_number_type" id="quotation_number_type">
                        
                        <option value disabled {{ old('quotation_number_type', null) === null ? 'selected' : '' }}>Please Select</option>
                        @foreach (config('quotations.quotation_types') as $key => $value)
                        <option value="{{ $value }}" {{ old('quotation_number_type', $quotation->quotation_number_type ) === (string) $value ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                        
                    </select>
                    @if($errors->has('quotation_number_type'))
                        <span class="text-danger">{{ $errors->first('quotation_number_type') }}</span>
                    @endif

                </div>

                <div class="col">

                    <label for="number">{{ trans('cruds.quotation.fields.number') }}</label>
                    <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="text" name="number" id="number" value="{{ old('number', $quotation->quotation_number ) }}">
                    @if($errors->has('number'))
                        <span class="text-danger">{{ $errors->first('number') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.quotation.fields.number_helper') }}</span>

                </div>

                <div class="col">

                    <label for="year">{{ trans('cruds.quotation.fields.year') }}</label>
                    <input class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" type="text" name="year" id="year" value="{{ old('year', $quotation->year ) }}">
                    @if($errors->has('year'))
                        <span class="text-danger">{{ $errors->first('year') }}</span>
                    @endif

                </div>
                
            </div>

            <div class="form-group">
                <label for="customer_address">{{ trans('cruds.quotation.fields.customer_address') }}</label>
                <textarea class="form-control {{ $errors->has('customer_address') ? 'is-invalid' : '' }}" type="text" name="customer_address" id="customer_address">{{ old('customer_address', $quotation->customer_address) }}</textarea>
                @if($errors->has('customer_address'))
                    <span class="text-danger">{{ $errors->first('customer_address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotation.fields.customer_address_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="status">{{ trans('cruds.quotation.fields.status') }}</label>

                <select class="status-input input-color form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}></option>
                    @foreach(App\Quotation::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $quotation->status ) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.enquiry.fields.status_helper') }}</span>
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
            
            
            {{-- <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.quotation.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ ($quotation->created_by ? $quotation->created_by->id : old('created_by_id')) == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotation.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.quotation.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ ($quotation->updated_by ? $quotation->updated_by->id : old('updated_by_id')) == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.quotation.fields.updated_by_helper') }}</span>
            </div> --}}

            <div class="form-group">
                <button class="btn btn-save" type="submit" id="quotation-upload">
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
        let quotationBtn = document.getElementById('quotation-upload')
        function loadSpinQuotation() {
            quotationBtn.innerHTML = 'Saving <i class="fas fa-spinner fa-spin"></i>'
        }

        $('#customFile').on('change',function(){
            let fileName = document.getElementById("customFile").files[0].name;
            
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection