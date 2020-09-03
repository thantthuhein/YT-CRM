@extends('layouts.admin')
@section('styles')
    <style>
        .multiselect{
            padding: 0;
            padding-top: 0.375rem;
        }
        .selectBox {
            /* width: 200px; */
            display: flex;
            flex-direction: column;
            padding: 0;
        }
    </style>
@endsection
@section('content')
@can('enquiry_create')

@if ($errors->any())
    <div class="alert alert-danger my-2" style="margin: 0 30px;">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="card-content" class="card content-card">
    <div class="enquiry-create">
        {{ trans('global.create') }} {{ trans('cruds.enquiry.title_singular') }}
    </div>
    <div class="create-enquiry-container">
        <form method="POST" action="{{ route("admin.enquiries.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="en-create-first-row pt-3">
                <div class="en-create-row-ele1">Enquiry Information</div>
                <div class="en-create-row-ele2">
                    <div class="form-group">
                        <label class="required" for="enquiries_type_id">{{ trans('cruds.enquiry.fields.enquiries_type') }}</label><br>
                        <select tabindex="1" class="form-control select2 {{ $errors->has('enquiries_type') ? 'is-invalid' : '' }}" name="enquiries_type_id" id="enquiries_type_id" onchange="changeEnquiry()" required>
                            @foreach($enquiries_types as $id => $enquiries_type)
                                <option value="{{ $id }}" {{ old('enquiries_type_id') == $id ? 'selected' : '' }}>{{ $enquiries_type }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('enquiries_type_id'))
                            <span class="text-danger">{{ $errors->first('enquiries_type_id') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.enquiry.fields.enquiries_type_helper') }}</span>
                    </div>
                </div>
                <div class="en-create-row-ele3">
                    <div class="form-group">
                        <label class="required" for="type_of_sales_id">{{ trans('cruds.enquiry.fields.type_of_sales') }}</label><br>
                        <select tabindex="2" class="input-color form-control select2 {{ $errors->has('type_of_sales') ? 'is-invalid' : '' }}" name="type_of_sales_id" id="type_of_sales_id" required>

                            @foreach($type_of_sales as $id => $type_of_sales)
                                <option value="{{ $id }}" {{ old('type_of_sales_id') == $id ? 'selected' : '' }}>
                                    {{ $type_of_sales }}
                                </option>
                            @endforeach

                        </select>

                        @if($errors->has('type_of_sales_id'))
                            <span class="text-danger">
                                {{ $errors->first('type_of_sales_id') }}
                            </span>
                        @endif

                        <span class="help-block">{{ trans('cruds.enquiry.fields.type_of_sales_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="en-create-second-row pt-3" style="flex-direction: column;">
                <div class="en-create-second-row pt-3" style="border: none;">
                    <div class="en-create-row-ele1">Customer Information</div>
                    <div class="en-create-row-ele2 row-ele2">
                        <div class="form-group nameCollectMain">
                            <label for="customer_name">{{ trans('cruds.customer.fields.name') }}</label><br>
                            <div class="row justify-content-center align-items-center m-0">
                                <input tabindex="3" class="input-color col m-0 form-control {{ $errors->has('customer_name') ? 'is-invalid' : '' }}" 
                                        type="text" autocomplete="off" 
                                        name="customer_name" 
                                        id="customer_name" value="{{ old('customer_name', '') }}" required>
                                <span data-toggle="tooltip" 
                                    data-placement="bottom" 
                                    title="unselect old customer"
                                    class="col-sm-2 remove-old-customer" style="color: red;font-size: 2em;"><i class="fas fa-times"></i></span>
                            </div>
                            <input  class="from-control" type="hidden" id="isOld" name="isOld" value=""/>
                            <input  class="from-control" type="hidden" id="customer_id" name="customer_id" value=""/>

                            @if($errors->has('customer_name'))
                                <span class="text-danger">{{ $errors->first('customer_name') }}</span>
                            @endif
                            <div class="nameCollectEle"></div>

                        </div>
                        <div class="form-group" id='cust-info-tbl' style='display: none; width: 100%;'>
                            <table class='table table-responsive'>
                                
                            </table>
                        </div>
                        <div class="form-group" id='email-phone-wrapper'>
                            <div class="form-group">
                                <label for="customer_email">{{ trans('cruds.customerEmail.fields.email') }}</label><br>
                                <input tabindex="5" class="input-color form-control {{ $errors->has('customer_email') ? 'is-invalid' : '' }}" type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', '') }}">
                                @if($errors->has('customer_email'))
                                    <span class="text-danger">{{ $errors->first('customer_email') }}</span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="customer_phone">{{ trans('cruds.customerPhone.fields.phone_number') }}</label><br>
                                <div class="phone_number_main">
                                    <input tabindex="6" type="number" class="input-color form-control {{ $errors->has('customer_phone') ? 'is-invalid' : '' }}" type="text" name="customer_phone[]" id="customer_phone" value="{{ old('customer_phone[]', '') }}">
                                <button type="button" onclick="addInputFieldValue()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                                @if($errors->has('phones'))
                                    <span class="text-danger">{{ $errors->first('phones') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="en-create-row-ele3">
                        <div class="form-group name-select companyCollectionMain">
                            <label for="company">{{ trans('cruds.enquiry.fields.company') }}</label><br>
                            <div class="row justify-content-center align-items-center m-0">
                                <input onkeyup="checkCompanyAndProject()" tabindex="4"
                                    class="input-color col form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" 
                                    type="text" autocomplete="off" name="company" 
                                    id="company" value="{{ old('company', '') }}">
                                <span data-toggle="tooltip" 
                                    data-placement="bottom" 
                                    title="unselect old company"
                                class="col-sm-2 remove-old-company" style="color: red;font-size: 2em;"><i class="fas fa-times"></i></span>
                            </div>
                            <input type='hidden' name="isOldCompany" id="isOldCompany" value=""/>
                            <input type="hidden" name="company_id" value="" id="company_id"/>
                            @if($errors->has('company'))
                                <span class="text-danger">{{ $errors->first('company') }}</span>
                            @endif
                            <div class="company-project-error"></div>
                            <div class="nameCompanyEle">
                                
                            </div>
                            <span class="help-block">{{ trans('cruds.enquiry.fields.location_helper') }}</span>
                        </div>
                    </div>                
                </div>

                <div class="phone_numbers_show d-flex mb-3" style="margin-left: 29%">
                    <input type="hidden" name="phones" id="phones" value="{{ old('phones', '') }}">
                    <ul class="selection-multiple__ul phone_number_show scrollbar mini-scrollbar" id="phone_number_list" style="width: 100%; overflow: auto;z-index:100;">
                        @if (old('phones'))
                            @foreach (json_decode(old('phones')) as $item)
                                <li data-id="{{ $item->id }}" class="selection-multiple-item">{{ $item->phone }}<span class="remove" data-id="{{$item->id}}" style="cursor:pointer" onclick="removeOldPhone({{$item->id}})">x</span></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="en-create-third-row pt-3">
                <div class="en-create-row-ele1">Project Information</div>
                <div class="en-create-row-ele2  row-ele2">
                    <div class="form-group">
                        <label for="project_name">{{ trans('cruds.project.fields.name') }}</label><br>
                        <input onkeyup="checkCompanyAndProject()" tabindex="7" class="input-color form-control {{ $errors->has('project_name') ? 'is-invalid' : '' }}" type="text" name="project_name" id="project_name" value="{{ old('project_name', '') }}">
                        @if($errors->has('project_name'))
                            <span class="text-danger">{{ $errors->first('project_name') }}</span>
                        @endif
                        <div class="company-project-error"></div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.enquiry.fields.has_installation') }}</label>
                        <select tabindex="9" class="input-color form-control {{ $errors->has('has_installation') ? 'is-invalid' : '' }}" name="has_installation" id="has_installation">
                            <option value disabled {{ old('has_installation', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Enquiry::HAS_INSTALLATION_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('has_installation', 'TBA') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('has_installation'))
                            <span class="text-danger">{{ $errors->first('has_installation') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.enquiry.fields.has_installation_helper') }}</span>
                    </div>
                    <div class="from-group">
                        <label>Aircon Types</label>
                        <div class="multiselect form-control input-color py-1">
                            <div tabindex="11" class="selectBox" onclick="showCheckboxes()">
                                <div class="select-element">
                                    
                                    <div class="select-element-label">
                                        <span id="select-element-label-text">Select</span>
                                    </div>
                                    <div class="select-element-icon">
                                        <span><i class="fas fa-caret-down"></i></span>
                                    </div>
                                </div>
                                
                            </div>                            
                        </div>
                        @if($errors->has('airconTypes'))
                            <span class="text-danger">{{ $errors->first('airconTypes') }}</span>
                        @endif
                        <div id="checkboxes">
                            @foreach($airconTypes as $airconType)
                                <label for="aircontype-{{$airconType->id}}">
                                    @if($airconType->parent == null )
                                        <input type="checkbox" id="aircontype-{{$airconType->id}}" 
                                            data-child= "{{ collect($childTree[$airconType->id]) }}" 
                                            data-parent='{{ $airconType->parent ?? "0" }}' 
                                            data-name="{{$airconType->type}}" 
                                            data-id="{{ $airconType->id }}" 
                                            value="{{$airconType->id}}" name="airconTypes[]" 
                                            {{ in_array($airconType->id, old('airconTypes', [])) ? "checked" : ""}}/>{{$airconType->type}}
                                    @elseif($airconType->parent == '5')
                                        <input class="place-checkbox" type="checkbox" id="aircontype-{{$airconType->id}}" 
                                            data-child= "{{ collect($childTree[$airconType->id]) }}" 
                                            data-parent='{{ $airconType->parent ?? "0" }}' 
                                            data-name="{{$airconType->type}}" 
                                            data-id="{{ $airconType->id }}" 
                                            value="{{$airconType->id}}" 
                                            name="airconTypes[]" 
                                            {{ in_array($airconType->id, old('airconTypes', [])) ? "checked" : ""}}/>{{$airconType->type}}
                                    @elseif($airconType->parent == '6')
                                        <input class="place-checkbox2" type="checkbox" 
                                            id="aircontype-{{$airconType->id}}" 
                                            data-child= "{{ collect($childTree[$airconType->id]) }}" 
                                            data-parent='{{ $airconType->parent ?? "0" }}' 
                                            value="{{$airconType->id}}" data-name="{{$airconType->type}}" 
                                            data-id="{{ $airconType->id }}" name="airconTypes[]"
                                            {{ in_array($airconType->id, old('airconTypes', [])) ? "checked" : ""}}/>{{$airconType->type}}
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>

                    
                </div>
                <div class="en-create-row-ele3 row-ele3">
                    <div class="form-group">
                        <label for="location">{{ trans('cruds.enquiry.fields.location') }}</label>
                        <input tabindex="8" class="input-color form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', '') }}">
                        @if($errors->has('location'))
                            <span class="input-color text-danger">{{ $errors->first('location') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.enquiry.fields.location_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.enquiry.fields.has_future_action') }}</label>
                        <select tabindex="10" class="future-input input-color form-control {{ $errors->has('has_future_action') ? 'is-invalid' : '' }}" name="has_future_action" id="has_future_action" onchange="changeFutureAction()">
                            <option value disabled {{ old('has_future_action', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Enquiry::HAS_FUTURE_ACTION_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('has_future_action', 'No') === (string) $key ? 'selected' : '' }} >{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('has_future_action'))
                            <span class="text-danger">{{ $errors->first('has_future_action') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.enquiry.fields.has_future_action_helper') }}</span>
                    </div>
                    <br>

                    <ul class="selection-multiple aircontype_select">
                        @if(old('airconTypes'))
                            @foreach($airconTypes as $airconType)
                                @if(in_array($airconType->id, old('airconTypes', [])))
                                    <li class="selection-multiple-item" value="{{ $airconType->type }}">
                                        <span style="white-space: nowrap;">
                                            {{ $airconType->type }}
                                        </span>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>

                </div>

            </div>
            <div class="en-create-fourth-row pt-3">
                <div class="en-create-row-ele1">Action</div>
                <div class="en-create-row-ele2 row-ele2">
                    <div class="form-group">
                        <label for="receiver_name">{{ trans('cruds.enquiry.fields.receiver_name') }}</label>
                        <input tabindex="12" class="input-color form-control {{ $errors->has('receiver_name') ? 'is-invalid' : '' }}" type="text" name="receiver_name" id="receiver_name" value="{{ old('receiver_name', '') }}">
                        @if($errors->has('receiver_name'))
                            <span class="text-danger">{{ $errors->first('receiver_name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.enquiry.fields.receiver_name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.enquiry.fields.status') }}</label>
                        <select tabindex="14" class="status-input input-color form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                            <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Enquiry::STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'pending') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.enquiry.fields.status_helper') }}</span>
                    </div>
                </div>
                <div class="en-create-row-ele3">
                    <div class="form-group">
                        <label for="sale_engineer_id">{{ trans('cruds.enquiry.fields.assign_engineer') }}</label>
                        <select tabindex="13" class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="sale_engineer_id" id="sale_engineer_id">
                            @foreach($sale_engineers as $id => $user)
                                <option value="{{ $id }}" {{ old('sale_engineer_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('sale_engineer_id'))
                            <span class="text-danger">{{ $errors->first('sale_engineer_id') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.enquiry.fields.user_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="en-create-fifth-row pt-3">
                <div class="form-group">
                    <button tabindex="15" class="btn btn-save" id="enquiry-update" data-id="0" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
                <div class="form-group ml-2">
                    <a href="{{ route('admin.enquiries.index') }}" tabindex="16" class="btn btn-cancel">
                        {{ trans('global.cancel') }}
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

@endcan

@endsection
@section('scripts')
<script src="/js/enquiry.js" ></script>
@endsection