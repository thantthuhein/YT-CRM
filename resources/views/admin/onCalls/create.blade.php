@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.onCall.service_call') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.on-calls.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="en-create-second-row pt-3">
                <div class="en-create-row-ele1">Customer Information</div>
                <div class="en-create-row-ele2 row-ele2 mb-3" style="justify-content: flex-end;">
                    <div class="form-group m-0">
                        <label for="customer_id">Existing Customer</label>
                        <select class="form-control customer-select select2 {{ $errors->has('customer_id') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                            <option value="">Please select</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" data-phones="{{ $customer->customerPhones()->pluck('phone_number') }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('customer_id'))
                            <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.onCall.fields.project_helper') }}</span>
                    </div>
                </div>
                <div class="en-create-row-ele2 row-ele2 mb-3" style="justify-content: flex-end;" id="create-enquiry-link">
                    <div class="form-group m-0">
                        <a href="{{ route('admin.enquiries.create') }}" target="_blank" style="color: red">
                            {{-- Not existing customer?<br>
                            Create enquiry here.. --}}
                            Couldn't find existing customer !
                        </a>
                    </div>
                </div>
            </div>

            <div class="en-create-second-row pt-3">
                <div class="en-create-row-ele1">Oncall Information</div>
                <div class="en-create-row-ele2 row-ele2">
                    <div class="form-group">
                        <label for="service_type_id">{{ trans('cruds.onCall.fields.service_type') }}</label>
                        <select class="form-control select2 {{ $errors->has('service_type') ? 'is-invalid' : '' }}" name="service_type_id" id="service_type_id" required>
                            @foreach($service_types as $id => $service_type)
                                <option value="{{ $id }}" {{ old('service_type_id') == $id ? 'selected' : '' }}>{{ $service_type }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('service_type_id'))
                            <span class="text-danger">{{ $errors->first('service_type_id') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.onCall.fields.service_type_helper') }}</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="tentative_date">Tentative Date</label>
                        <input type='text' class='form-control date {{ $errors->has('tentative_date') ? 'is-invalid' : ''}}' 
                                name='tentative_date' id="tentative_date"
                                value="{{ old('tentative_date') }}" required>
                        @if($errors->has('tentative_date'))
                            <span class="text-danger">{{ $errors->first('tentative_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.onCall.fields.sale_contract_helper') }}</span>
                    </div>
                </div>
                <div class="en-create-row-ele2 row-ele2" style="width: 40%">
                    <div class="form-group">
                        <label for="remark">{{ trans('cruds.onCall.fields.remark') }}</label>
                        <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark" required>{!! old('remark') !!}</textarea>
                        @if($errors->has('remark'))
                            <span class="text-danger">{{ $errors->first('remark') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.onCall.fields.remark_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="form-group my-3" style="height: auto">
                <div class="en-create-row-ele1 mb-3" style="display: block">Sale Contract Information</div>
                <div class="en-create-row-ele2 row-ele2" style="width: 100%">
                    <div class="form-group">
                        {{-- <label for="sale_contract_id">{{ trans('cruds.onCall.fields.sale_contract') }}</label> --}}
                        <table class="table table-bordered table-striped mb-3">
                            <thead>
                                <tr>
                                    <th>
                                        
                                    </th>
                                    <th>
                                        Project Name
                                    </th>
                                    <th>
                                        Company Name
                                    </th>
                                    <th>
                                        Phone
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                </tr>
                            </thead>
                            <tbody id='sale_contract_id'>

                            </tbody>
                        </table>
                        @if($errors->has('sale_contract_id'))
                            <span class="text-danger">{{ $errors->first('sale_contract_id') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.onCall.fields.sale_contract_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    {{ trans('global.save') }}
                </button>
                <a class="btn btn-cancel" href="{{ route('admin.on-calls.index') }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>


    </div>
</div>
@endsection
@section('scripts')
    <script>
         $(function () {
            $('#tentative_date').datetimepicker();
        });
        // $('#tentative_date').datetimepicker({
        //     leftArrow: 'left',
        //     rightArrow: 'right',
        // });
        
        function matchStart(params, data) {
            
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Skip if there is no 'children' property
            if (typeof data.children === 'undefined') {
                return null;
            }

            // `data.children` contains the actual options that we are matching against
            var filteredChildren = [];
            $.each(data.children, function (idx, child) {
                if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                filteredChildren.push(child);
                }
            });

            // If we matched any of the timezone group's children, then set the matched children on the group
            // and return the group object
            if (filteredChildren.length) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.children = filteredChildren;

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $(".customer-search").select2({
            matcher: matchStart
        });

        $('.customer-select').change(function(){
            let customer_id = $(this).val();

            if($(this).val() == ""){
                $('#create-enquiry-link').css({
                    display: 'flex'
                })
            }
            else{
                $('#create-enquiry-link').css({
                    display: 'none'
                })
            }
            
            if(customer_id != ""){
                let url = `/api/v1/customers/${customer_id}/sale-contracts`;
                fetch(url, {
                    'method' : "POST",
                    'headers' : {
                        'Content-type' : 'application/json',
                        'Accept' : 'application/json'
                    },
                })
                .then((data) => data.json())
                .then(saleContracts => {
                    
                    let enquiries = saleContracts['enquiries'];
                    let quotations = saleContracts['quotations'];
                    
                    let attachString = "";

                    if(enquiries.length > 0){
                        if (enquiries.length == 1) {
                            enquiries.forEach(function(enquiry){
                            let phones = [];
                            for(let phone of enquiry.customer.customer_phones)
                            {
                                phones.push(phone.phone_number);
                            }
                            
                            attachString += `<tr>
                                                <td>
                                                    <input type="radio" name="sale_contract_id" value="${enquiry.sale_contract.id}" required checked>
                                                </td>
                                                <td>${enquiry.project ? enquiry.project.name : "No Project Name"}</td>
                                                <td>${enquiry.company ? enquiry.company.name : 'No Company Name'}</td>
                                                <td>${phones.join(', ') ?? ""}</td>
                                                <td>${enquiry.customer.email ? enquiry.customer.email : 'No Email'}</td>
                                             </tr>`;
                            })     
                        } else {
                            enquiries.forEach(function(enquiry){
                                let phones = [];
                                for(let phone of enquiry.customer.customer_phones)
                                {
                                    phones.push(phone.phone_number);
                                }
                                
                                attachString += `<tr>
                                                    <td>
                                                        <input type="radio" name="sale_contract_id" value="${enquiry.sale_contract.id}" required>
                                                    </td>
                                                    <td>${enquiry.project ? enquiry.project.name : 'No Project Name'}</td>
                                                    <td>${enquiry.company ? enquiry.company.name : 'No Company Name'}</td>
                                                    <td>${phones.join(', ') ?? ""}</td>
                                                    <td>${enquiry.customer.email ? enquiry.customer.email : 'No Email'}</td>
                                                </tr>`;
                                // let row = document.getElementById('sale_contract_id').insertRow();
                                // let checkboxCol = row.insertCell(0);
                                // let projCol = row.insertCell(1);
                                // let compCol = row.insertCell(2);
                                // let phonesCol = row.insertCell(3);
                                // let emailCol = row.insertCell(4);

                                // checkboxCol.innerHTML = `<input type="radio" name="sale_contract_id" value="${enquiry.sale_contract.id}>`;
                                // projCol.innerHTML = `${enquiry.project.name}`;
                                // compCol.innerHTML = `${enquiry.company.name}`;
                                // phonesCol.innerHTML = `${phones.join(', ')}`;
                                // emailCol.innerHTML = `${enquiry.customer.email}`;

                            }) 
                        }
                    }

                    if(quotations.length > 0){
                        if (quotations.length == 1) {
                            quotations.forEach(function(quotation){
                                let phones = [];
                                for(let phone of quotation.customer.customer_phones)
                                {
                                    phones.push(phone.phone_number);
                                }
                                
                                attachString += `<tr>
                                                    <td>
                                                        <input type="radio" name="sale_contract_id" value="${quotation.sale_contract.id}" required checked>
                                                    </td>
                                                    <td>${quotation.enquiries.project ? quotation.enquiries.project.name : "No Project Name"}</td>
                                                    <td>${quotation.enquiries.company ? quotation.enquiries.company.name : 'No Company Name'}</td>
                                                    <td>${phones.join(', ') ?? ""}</td>
                                                    <td>${quotation.customer.email ? quotation.customer.email : 'No Email'}</td>
                                                </tr>`;
                            }) 
                        } else {
                            quotations.forEach(function(quotation){
                                let phones = [];
                                for(let phone of quotation.customer.customer_phones)
                                {
                                    phones.push(phone.phone_number);
                                }
                                
                                attachString += `<tr>
                                                    <td>
                                                        <input type="radio" name="sale_contract_id" value="${quotation.sale_contract.id}" required>
                                                    </td>
                                                    <td>${quotation.enquiries.project ? quotation.enquiries.project.name : "No Project Name"}</td>
                                                    <td>${quotation.enquiries.company ? quotation.enquiries.company.name : 'No Company Name'}</td>
                                                    <td>${phones.join(', ') ?? ''}</td>
                                                    <td>${quotation.customer.email ? quotation.customer.email : 'No Email'}</td>
                                                </tr>`;
                            }) 
                        }
                    }

                    $('#sale_contract_id').html("");
                    $('#sale_contract_id').append(attachString);
                })
            }
            else{
                $('#sale_contract_id').html("");
            }
        });
        
    </script>
@endsection