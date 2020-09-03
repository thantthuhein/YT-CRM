<div class="collapse" id="claim_action_collapse">
    <div class="card text-dark mt-3">
        <div class="card-header">
            Upload necessary PDFs
        </div>

        <div class="card-body">
            <form method="POST" class="row" action="{{ route("admin.warranty-claim-actions.update", [$warrantyClaimAction->id]) }}" enctype="multipart/form-data" onsubmit="loadSpinnerEditClaim()">
                @method('PUT')
                @csrf
                <div class="col-6">
                    <div class="form-group">
                        <label for="daikin_rep_name">{{ trans('cruds.warrantyClaimAction.fields.daikin_rep_name') }}</label>
                        <input class="form-control {{ $errors->has('daikin_rep_name') ? 'is-invalid' : '' }}" type="text" name="daikin_rep_name" id="daikin_rep_name" value="{{ old('daikin_rep_name', $warrantyClaimAction->daikin_rep_name) }}">
                        @if($errors->has('daikin_rep_name'))
                            <span class="text-danger">{{ $errors->first('daikin_rep_name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.daikin_rep_name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="daikin_rep_phone_number">{{ trans('cruds.warrantyClaimAction.fields.daikin_rep_phone_number') }}</label>
                        <input class="form-control {{ $errors->has('daikin_rep_phone_number') ? 'is-invalid' : '' }}" type="number" name="daikin_rep_phone_number" id="daikin_rep_phone_number" value="{{ old('daikin_rep_phone_number', $warrantyClaimAction->daikin_rep_phone_number) }}" step="1">
                        @if($errors->has('daikin_rep_phone_number'))
                            <span class="text-danger">{{ $errors->first('daikin_rep_phone_number') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.daikin_rep_phone_number_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="servicing_team_id">Repair Team</label>
                        <select class="form-control select2 {{ $errors->has('repair_team_id') ? 'is-invalid' : '' }}" name="repair_team_id" id="repair_team_id" style="width: 100%" required>
                            @foreach($repair_teams as $id => $leader_name)
                                <option value="{{ $id }}" 
                                {{-- {{ old('repair_team_id', $warrantyClaimAction->repair_teams->first()->i) == $id ? 'selected' : '' }} --}}
                                >{{ $leader_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('repair_team_id'))
                            <span class="text-danger">{{ $errors->first('repair_team_id') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.onCall.fields.service_type_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="estimate_date">{{ trans('cruds.warrantyClaimAction.fields.estimate_date') }}</label>
                        <input class="form-control date {{ $errors->has('estimate_date') ? 'is-invalid' : '' }}" type="text" name="estimate_date" id="estimate_date" value="{{ old('estimate_date', $warrantyClaimAction->estimate_date) }}">
                        @if($errors->has('estimate_date'))
                            <span class="text-danger">{{ $errors->first('estimate_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.estimate_date_helper') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="actual_date">{{ trans('cruds.warrantyClaimAction.fields.actual_date') }}</label>
                        <input class="form-control date {{ $errors->has('actual_date') ? 'is-invalid' : '' }}" type="text" name="actual_date" id="actual_date" value="{{ old('actual_date', $warrantyClaimAction->actual_date) }}" required>
                        @if($errors->has('actual_date'))
                            <span class="text-danger">{{ $errors->first('actual_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.actual_date_helper') }}</span>
                    </div>



                    <div class="form-group">
                        <label for="service_report_pdf_ywar_taw">{{ trans('cruds.warrantyClaimAction.fields.service_report_pdf_ywar_taw') }}</label>
                        {{-- @if($warrantyClaimAction->service_report_pdf_ywar_taw)
                            <a href="{{ $warrantyClaimAction->service_report_pdf_ywar_taw }}" target="_blank">View previous uploaded file</a>
                        @endif --}}
                        <input name="service_report_pdf_ywar_taw[]" type="file" accept="application/pdf" class="form-control {{ $errors->has('service_report_pdf_ywar_taw') ? 'is-invalid' : '' }}" id="service_report_pdf_ywar_taw" multiple>
                        @if($errors->has('service_report_pdf_ywar_taw'))
                            <span class="text-danger">{{ $errors->first('service_report_pdf_ywar_taw') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.service_report_pdf_ywar_taw_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="service_report_pdf_daikin">{{ trans('cruds.warrantyClaimAction.fields.service_report_pdf_daikin') }}</label>
                        {{-- @if($warrantyClaimAction->service_report_pdf_daikin)
                            <a href="{{ $warrantyClaimAction->service_report_pdf_daikin }}" target="_blank">View previous uploaded file</a>
                        @endif --}}
                        <input name="service_report_pdf_daikin[]" type="file" accept="application/pdf" class="form-control {{ $errors->has('service_report_pdf_daikin') ? 'is-invalid' : '' }}" id="service_report_pdf_daikin" multiple>
                        @if($errors->has('service_report_pdf_daikin'))
                            <span class="text-danger">{{ $errors->first('service_report_pdf_daikin') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.service_report_pdf_daikin_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="deliver_order_pdf">{{ trans('cruds.warrantyClaimAction.fields.deliver_order_pdf') }}</label>
                        {{-- @if($warrantyClaimAction->deliver_order_pdf)
                            <a href="{{ $warrantyClaimAction->deliver_order_pdf }}" target="_blank">View previous uploaded file</a>
                        @endif --}}
                        <input name="deliver_order_pdf[]" type="file" accept="application/pdf" class="form-control {{ $errors->has('deliver_order_pdf') ? 'is-invalid' : '' }}" id="deliver_order_pdf" multiple>
                        @if($errors->has('deliver_order_pdf'))
                            <span class="text-danger">{{ $errors->first('deliver_order_pdf') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.warrantyClaimAction.fields.deliver_order_pdf_helper') }}</span>
                    </div>



                    <div class="form-group">
                        <label for="remark">{{ trans('cruds.onCall.fields.remark') }}</label>
                        <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark') !!}</textarea>
                        @if($errors->has('remark'))
                            <span class="text-danger">{{ $errors->first('remark') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.onCall.fields.remark_helper') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-save" type="submit" id="warranty-claim-edit-claim-pdf">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>