@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.quotationRevision.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.quotation-revisions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.id') }}
                        </th>
                        <td>
                            {{ $quotationRevision->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.quotation_revision') }}
                        </th>
                        <td>
                            {{ $quotationRevision->quotation_revision }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.quotation') }}
                        </th>
                        <td>
                            {{ $quotationRevision->quotation->number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.quoted_date') }}
                        </th>
                        <td>
                            {{ $quotationRevision->quoted_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.quotation_pdf') }}
                        </th>
                        <td>
                            @if($quotationRevision->quotation_pdf)
                                <a href="{{ $quotationRevision->quotation_pdf }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.status') }}
                        </th>
                        <td>
                            {{ App\QuotationRevision::STATUS_SELECT[$quotationRevision->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.created_by') }}
                        </th>
                        <td>
                            {{ $quotationRevision->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quotationRevision.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $quotationRevision->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.quotation-revisions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection