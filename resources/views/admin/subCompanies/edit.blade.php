@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.subCompany.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sub-companies.update", [$subCompany->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="company_name">{{ trans('cruds.subCompany.fields.company_name') }}</label>
                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', $subCompany->company_name) }}">
                @if($errors->has('company_name'))
                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.company_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_person_name">{{ trans('cruds.subCompany.fields.contact_person_name') }}</label>
                <input class="form-control {{ $errors->has('contact_person_name') ? 'is-invalid' : '' }}" type="text" name="contact_person_name" id="contact_person_name" value="{{ old('contact_person_name', $subCompany->contact_person_name) }}">
                @if($errors->has('contact_person_name'))
                    <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.contact_person_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_person_phone_number">{{ trans('cruds.subCompany.fields.contact_person_phone_number') }}</label>
                <input class="form-control {{ $errors->has('contact_person_phone_number') ? 'is-invalid' : '' }}" type="number" name="contact_person_phone_number" id="contact_person_phone_number" value="{{ old('contact_person_phone_number', $subCompany->contact_person_phone_number) }}" step="1">
                @if($errors->has('contact_person_phone_number'))
                    <span class="text-danger">{{ $errors->first('contact_person_phone_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.contact_person_phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.subCompany.fields.is_active') }}</label>
                @foreach(App\SubCompany::IS_ACTIVE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="is_active_{{ $key }}" name="is_active" value="{{ $key }}" {{ old('is_active', $subCompany->is_active) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('is_active'))
                    <span class="text-danger">{{ $errors->first('is_active') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.subCompany.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ ($subCompany->created_by ? $subCompany->created_by->id : old('created_by_id')) == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by_id'))
                    <span class="text-danger">{{ $errors->first('created_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="updated_by_id">{{ trans('cruds.subCompany.fields.updated_by') }}</label>
                <select class="form-control select2 {{ $errors->has('updated_by') ? 'is-invalid' : '' }}" name="updated_by_id" id="updated_by_id">
                    @foreach($updated_bies as $id => $updated_by)
                        <option value="{{ $id }}" {{ ($subCompany->updated_by ? $subCompany->updated_by->id : old('updated_by_id')) == $id ? 'selected' : '' }}>{{ $updated_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('updated_by_id'))
                    <span class="text-danger">{{ $errors->first('updated_by_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.updated_by_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection