@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.subCompany.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sub-companies.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="company_name">{{ trans('cruds.subCompany.fields.company_name') }}</label>
                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', '') }}">
                @if($errors->has('company_name'))
                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.company_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_person_name">{{ trans('cruds.subCompany.fields.contact_person_name') }}</label>
                <input class="form-control {{ $errors->has('contact_person_name') ? 'is-invalid' : '' }}" type="text" name="contact_person_name" id="contact_person_name" value="{{ old('contact_person_name', '') }}">
                @if($errors->has('contact_person_name'))
                    <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.contact_person_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_person_phone_number">{{ trans('cruds.subCompany.fields.contact_person_phone_number') }}</label>
                <input class="form-control {{ $errors->has('contact_person_phone_number') ? 'is-invalid' : '' }}" type="text" name="contact_person_phone_number" id="contact_person_phone_number" value="{{ old('contact_person_phone_number') }}" step="1">
                @if($errors->has('contact_person_phone_number'))
                    <span class="text-danger">{{ $errors->first('contact_person_phone_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.contact_person_phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.subCompany.fields.is_active') }}</label>
                @foreach(App\SubCompany::IS_ACTIVE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="is_active_{{ $key }}" name="is_active" value="{{ $key }}" {{ old('is_active', '1') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('is_active'))
                    <span class="text-danger">{{ $errors->first('is_active') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subCompany.fields.is_active_helper') }}</span>
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