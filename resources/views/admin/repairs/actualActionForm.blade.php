<form method="POST" action="{{ route('admin.repairs.actual-action', [$repair]) }}" enctype="multipart/form-data" onsubmit="loadSpinner()">
    @csrf
    <div class="form-group">
        <label for="actual_date">{{ trans('cruds.repair.fields.actual_date') }}</label>
        <input class="form-control date {{ $errors->has('actual_date') ? 'is-invalid' : '' }}" type="text" name="actual_date" id="actual_date" value="{{ old('actual_date', $repair->actual_date) }}" required>
        @if($errors->has('actual_date'))
            <span class="text-danger">{{ $errors->first('actual_date') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.repair.fields.actual_date_helper') }}</span>
    </div>
    <div class="form-group">
        <label style="display: block;">{{ trans('cruds.repair.fields.has_spare_part_replacement') }}</label>
        @foreach(App\Repair::HAS_SPARE_PART_REPLACEMENT_RADIO as $key => $label)
            <div class="mr-2 form-check {{ $errors->has('has_spare_part_replacement') ? 'is-invalid' : '' }}" style="display: inline-block;">
                <input class="form-check-input" type="radio" id="has_spare_part_replacement_{{ $key }}" name="has_spare_part_replacement" value="{{ $key }}" {{ old('has_spare_part_replacement', $repair->has_spare_part_replacement) === (string) $key ? 'checked' : '' }} required>
                <label class="form-check-label uppercase" for="has_spare_part_replacement_{{ $key }}">{{ $label }}</label>
            </div>
        @endforeach
        @if($errors->has('has_spare_part_replacement'))
            <span class="text-danger">{{ $errors->first('has_spare_part_replacement') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.repair.fields.has_spare_part_replacement_helper') }}</span>
    </div>
    <div class="form-group">
        <label for="service_report_pdf">{{ trans('cruds.repair.fields.service_report_pdf') }}</label>
        <input type='file' name="service_report_pdf" accept="application/pdf" 
                class="form-control {{ $errors->has('service_report_pdf') ? 'is-invalid' : '' }}" id="service_report_pdf">
        @if($errors->has('service_report_pdf'))
            <span class="text-danger">{{ $errors->first('service_report_pdf') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.repair.fields.service_report_pdf_helper') }}</span>
    </div>

    {{-- <div class="form-group">
        <label for="remark">{{ trans('cruds.onCall.fields.remark') }}</label>
        <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
        @if($errors->has('remark'))
            <span class="text-danger">{{ $errors->first('remark') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.onCall.fields.remark_helper') }}</span>
    </div> --}}

    <div class="form-group">
        <button class="btn btn-save" type="submit" id="repair-actual-action-store">{{ $repair->actual_date ? "Update" : "Save" }}</button>
        {{-- <a class="btn btn-default" href="{{ route('admin.repairs.show', [$repair]) }}">
            {{ trans('global.cancel') }}
        </a> --}}
    </div>
</form>