@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.saleContractPdf.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sale-contract-pdfs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.id') }}
                        </th>
                        <td>
                            {{ $saleContractPdf->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.sale_contract') }}
                        </th>
                        <td>
                            {{ $saleContractPdf->sale_contract->has_installation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.iteration') }}
                        </th>
                        <td>
                            {{ $saleContractPdf->iteration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.url') }}
                        </th>
                        <td>
                            @if($saleContractPdf->url)
                                <a href="{{ $saleContractPdf->url->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.title') }}
                        </th>
                        <td>
                            {{ $saleContractPdf->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saleContractPdf.fields.uploaded_by') }}
                        </th>
                        <td>
                            {{ $saleContractPdf->uploaded_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sale-contract-pdfs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection