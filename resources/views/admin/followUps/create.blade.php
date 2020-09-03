@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header d-flex">
        <p>{{ trans('global.create') }} {{ trans('cruds.followUp.title_singular') }}</p>
        <div class="ml-auto">
            <a href="{{ route('admin.quotations.show', $quotation) }}" class="btn btn-sm btn-save">Go To Quotation</a>
        </div>
    </div>

    <div class="card-body">

        <div class="container pl-0">
            <div class="row">
                <div class="col-6">
                    <p class="font-weight-bold">Quotation Number</p>
                    <p>{{ $quotation->number }}</p>
                    <p class="font-weight-bold">Revised Quotation</p>
                    <p>
                        @if ( $quotation_revision->quotation_revision === NULL )
                        First Quotation
                        <input type="hidden" name="quotation_revision_id" id="quotation_revision_id" value="{{ $quotation_revision->id }}">
                        @else
                        {{ $quotation_revision->quotation_revision }}
                        <input type="hidden" name="quotation_revision_id" id="quotation_revision_id" value="{{ $quotation_revision->id }}">
                        @endif
                    </p>
                    <p class="font-weight-bold">
                        Latest Follow Up Contact Number
                    </p>
                    @if ($quotation_revision->followUps)                        
                        <p>{{ $quotation_revision->followUps()->latest()->first()->contact_number ?? '' }}</p>
                    @endif
                </div>
            </div>
        </div>

        <hr>

        <form method="POST" action="{{ route("admin.follow-ups.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                @if ( $quotation_revision->quotation_revision === NULL )
                <input type="hidden" name="quotation_revision_id" id="quotation_revision_id" value="{{ $quotation_revision->id }}">
                @else
                <input type="hidden" name="quotation_revision_id" id="quotation_revision_id" value="{{ $quotation_revision->id }}">
                @endif
            </div>

            <div class="form-group">
                <label for="remark">{{ trans('cruds.followUp.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.remark_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="follow_up_time">{{ trans('cruds.followUp.fields.follow_up_time') }}</label>
                <input class="form-control date {{ $errors->has('follow_up_time') ? 'is-invalid' : '' }}" type="text" name="follow_up_time" id="follow_up_time" value="{{ old('follow_up_time') }}">
                @if($errors->has('follow_up_time'))
                    <span class="text-danger">{{ $errors->first('follow_up_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.follow_up_time_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="contact_person">{{ trans('cruds.followUp.fields.contact_person') }}</label>
                @if (! $quotation_revision->followUps->isEmpty())                    
                <input class="form-control {{ $errors->has('contact_person') ? 'is-invalid' : '' }}" type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $quotation_revision->followUps()->latest()->first()->contact_person) }}">
                @else
                <input class="form-control {{ $errors->has('contact_person') ? 'is-invalid' : '' }}" type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', '') }}">                    
                @endif
                @if($errors->has('contact_person'))
                    <span class="text-danger">{{ $errors->first('contact_person') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.followUp.fields.contact_person_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="contact_number">{{ trans('cruds.followUp.fields.contact_number') }}</label>
                @if (! $quotation_revision->followUps->isEmpty())
                    <input class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" type="number" name="contact_number" id="contact_number" value="{{ old('contact_number', $quotation_revision->followUps()->latest()->first()->contact_number) }}" step="1">
                @else                    
                    <input class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" type="number" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" step="1">
                @endif

                @if($errors->has('contact_number'))
                    <span class="text-danger">{{ $errors->first('contact_number') }}</span>
                @endif

                <span class="help-block">{{ trans('cruds.followUp.fields.contact_number_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label>{{ trans('cruds.followUp.fields.status') }}</label>
                @foreach(App\FollowUp::STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $quotation->status) === (string) $key ? 'checked' : '' }}>
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