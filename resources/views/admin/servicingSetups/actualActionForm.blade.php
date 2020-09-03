<div>
    <form method="POST" action="{{ route('admin.servicing-setups.actual-action', [$servicingSetup]) }}" enctype="multipart/form-data"
    onsubmit="loadPerformActionSpinner()"
    >
        @csrf
        <div class="form-group">
            <label>{{ trans('cruds.servicingSetup.fields.is_major') }}</label>
            @foreach(App\ServicingSetup::IS_MAJOR_RADIO as $key => $label)
                <div class="form-check {{ $errors->has('is_major') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="radio" id="is_major_{{ $key }}" name="is_major" value="{{ $key }}" {{ old('is_major', $servicingSetup->is_major) === (string) $key ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_major_{{ $key }}">{{ $label }}</label>
                </div>
            @endforeach
            @if($errors->has('is_major'))
                <span class="text-danger">{{ $errors->first('is_major') }}</span>
            @endif
            <span class="help-block">{{ trans('cruds.servicingSetup.fields.is_major_helper') }}</span>
        </div>
    
        <div class="form-group">
            <label for="actual_date">{{ trans('cruds.repair.fields.actual_date') }}</label>
            <input class="form-control date {{ $errors->has('actual_date') ? 'is-invalid' : '' }}" type="text" name="actual_date" id="actual_date" value="{{ old('actual_date', $servicingSetup->actual_date) }}" required>
            @if($errors->has('actual_date'))
                <span class="text-danger">{{ $errors->first('actual_date') }}</span>
            @endif
            <span class="help-block">{{ trans('cruds.repair.fields.actual_date_helper') }}</span>
        </div>
    
        <div class="form-group">
            <label for="service_report_pdf">{{ trans('cruds.repair.fields.service_report_pdf') }}</label>
            <input type='file' name="service_report_pdf" accept="application/pdf" 
                    class="form-control {{ $errors->has('service_report_pdf') ? 'is-invalid' : '' }}" id="service_report_pdf" required>
            @if($errors->has('service_report_pdf'))
                <span class="text-danger">{{ $errors->first('service_report_pdf') }}</span>
            @endif
            <span class="help-block">{{ trans('cruds.repair.fields.service_report_pdf_helper') }}</span>
        </div>
    
        {{-- <div class="form-group">
            <label for="status">Maintenance Status</label>
            <select name="status" id="status" class="form-control">
                @foreach (App\ServicingSetup::STATUS as $key => $label)
                    <option value="{{ $key }}" {{ old('status', $servicingSetup->status ) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div> --}}
    
        <div class="form-group">
            <label for="remark">{{ trans('cruds.onCall.fields.remark') }}</label>
            <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
            @if($errors->has('remark'))
                <span class="text-danger">{{ $errors->first('remark') }}</span>
            @endif
            <span class="help-block">{{ trans('cruds.onCall.fields.remark_helper') }}</span>
        </div>
        <div class="form-group">
    
            <button class="btn btn-save" type="submit" id="actual-action-servicing-setup">{{ $servicingSetup->actual_date ? trans('global.update') : trans('global.save') }}</button>
    
        </div>
    </form>
    {{-- <button type="submit" class="btn btn-primary" onclick="perform()">Click</button> --}}
</div>
