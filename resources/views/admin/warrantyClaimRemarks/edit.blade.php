@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.warrantyClaimRemark.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.warranty-claim-remarks.update", [$warrantyClaimRemark->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="warranty_claim_id">{{ trans('cruds.warrantyClaimRemark.fields.warranty_claim') }}</label>
                <select class="form-control select2 {{ $errors->has('warranty_claim') ? 'is-invalid' : '' }}" name="warranty_claim_id" id="warranty_claim_id">
                    @foreach($warranty_claims as $id => $warranty_claim)
                        <option value="{{ $id }}" {{ ($warrantyClaimRemark->warranty_claim ? $warrantyClaimRemark->warranty_claim->id : old('warranty_claim_id')) == $id ? 'selected' : '' }}>{{ $warranty_claim }}</option>
                    @endforeach
                </select>
                @if($errors->has('warranty_claim_id'))
                    <span class="text-danger">{{ $errors->first('warranty_claim_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimRemark.fields.warranty_claim_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.warrantyClaimRemark.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark', $warrantyClaimRemark->remark) !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaimRemark.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection