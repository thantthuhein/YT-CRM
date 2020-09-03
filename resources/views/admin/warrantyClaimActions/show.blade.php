@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.warrantyClaimAction.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.warranty-claim-actions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.daikin_rep_name') }}
                        </th>
                        <td>
                            {{ $warrantyClaimAction->daikin_rep_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.daikin_rep_phone_number') }}
                        </th>
                        <td>
                            {{ $warrantyClaimAction->daikin_rep_phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.service_report_pdf_ywar_taw') }}
                        </th>
                        <td>
                            @if($warrantyClaimAction->service_report_pdf_ywar_taw)
                                <a href="{{ $warrantyClaimAction->service_report_pdf_ywar_taw->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.service_report_pdf_daikin') }}
                        </th>
                        <td>
                            @if($warrantyClaimAction->service_report_pdf_daikin)
                                <a href="{{ $warrantyClaimAction->service_report_pdf_daikin->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.deliver_order_pdf') }}
                        </th>
                        <td>
                            @if($warrantyClaimAction->deliver_order_pdf)
                                <a href="{{ $warrantyClaimAction->deliver_order_pdf->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.estimate_date') }}
                        </th>
                        <td>
                            {{ $warrantyClaimAction->estimate_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.actual_date') }}
                        </th>
                        <td>
                            {{ $warrantyClaimAction->actual_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.created_by') }}
                        </th>
                        <td>
                            {{ $warrantyClaimAction->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimAction.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $warrantyClaimAction->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.warranty-claim-actions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection