<div class="card text-dark mb-3">
    <div class="card-header">
        Change Status
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.warranty-claims.update", [$warrantyClaim]) }}" onsubmit="return confirm('Sure to update status?');">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>{{ trans('cruds.warrantyClaim.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\WarrantyClaim::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $warrantyClaim->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.warrantyClaim.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-save" type="submit">
                    {{ trans('global.update') }}
                </button>
            </div>
        </form>


    </div>
</div>