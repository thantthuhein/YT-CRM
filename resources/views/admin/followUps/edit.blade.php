@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.followUp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.follow-ups.update", [$followUp->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf


            {{-- <div class="form-group">
                <label for="quotation_revision_id">{{ trans('cruds.followUp.fields.quotation_revision') }}</label>
                <select class="form-control select2 {{ $errors->has('quotation_revision') ? 'is-invalid' : '' }}" name="quotation_revision_id" id="quotation_revision_id">
                    @foreach($quotation_revisions as $id => $quotation_revision)
                        <option value="{{ $id }}" {{ ($followUp->quotation_revision ? $followUp->quotation_revision->id : old('quotation_revision_id')) == $id ? 'selected' : '' }}>{{ $quotation_revision }}</option>
                    @endforeach
                </select>
                @if($errors->has('quotation_revision_id'))
                    <span class="text-danger">{{ $errors->first('quotation_revision_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.quotation_revision_helper') }}</span>
            </div> --}}


            {{-- <div class="form-group">
                <label for="user_id">{{ trans('cruds.followUp.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ ($followUp->user ? $followUp->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <span class="text-danger">{{ $errors->first('user_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.user_helper') }}</span>
            </div> --}}


            <div class="form-group">
                <label for="remark">{{ trans('cruds.followUp.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark', $followUp->remark) !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.remark_helper') }}</span>
            </div>


            <div class="form-group">
                <label for="follow_up_time">{{ trans('cruds.followUp.fields.follow_up_time') }}</label>
                <input class="form-control date {{ $errors->has('follow_up_time') ? 'is-invalid' : '' }}" type="text" name="follow_up_time" id="follow_up_time" value="{{ old('follow_up_time', $followUp->follow_up_time) }}">
                @if($errors->has('follow_up_time'))
                    <span class="text-danger">{{ $errors->first('follow_up_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.follow_up_time_helper') }}</span>
            </div>


            <div class="form-group">
                <label for="contact_person">{{ trans('cruds.followUp.fields.contact_person') }}</label>
                <input class="form-control {{ $errors->has('contact_person') ? 'is-invalid' : '' }}" type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $followUp->contact_person) }}">
                @if($errors->has('contact_person'))
                    <span class="text-danger">{{ $errors->first('contact_person') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.contact_person_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_number">{{ trans('cruds.followUp.fields.contact_number') }}</label>
                <input class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" type="number" name="contact_number" id="contact_number" value="{{ old('contact_number', $followUp->contact_number) }}" step="1">
                @if($errors->has('contact_number'))
                    <span class="text-danger">{{ $errors->first('contact_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.contact_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.followUp.fields.status') }}</label>
                @foreach(App\FollowUp::STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $followUp->status) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.status_helper') }}</span>
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