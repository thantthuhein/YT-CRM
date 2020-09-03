@extends('layouts.admin')

@section('content')  
<div class="card content-card display-card text-white">
    <div class="card-header text-white">
        {{ trans('global.show') }} {{ trans('cruds.saleContract.title') }}
    </div>

    <div class="card-body"> 

        @include('admin.saleContracts.infoTable')

        <div class="card display-card">
            <div class="table-responsive">
                <table class="en-list table table-borderless table-striped scrollbar">
                    <thead>
                        <tr>
                            <th width="10">
    
                            </th>
                            <th>
                                #
                            </th>
                            <th>
                                {{ trans('cruds.saleContractPdf.fields.iteration') }}
                            </th>
                            <th>
                                {{ trans('cruds.saleContractPdf.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.saleContractPdf.fields.uploaded_by') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($saleContractPdfs as $key => $saleContractPdf)
                            <tr data-entry-id="{{ $saleContractPdf->id }}">
                                <td>
    
                                </td>
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $saleContractPdf->iteration ?? '' }}
                                </td>
                                <td>
                                    {{ $saleContractPdf->title ?? '' }}
                                </td>
                                <td>
                                    {{ $saleContractPdf->uploaded_by->name ?? '' }}
                                </td>
                                <td>
                                    <a href="{{ $saleContractPdf->url }}" class="btn btn-sm btn-create" target="_blank"><i class="far fa-eye"></i> View</a>
                                </td>
    
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
                <div class="my-3">
                    {{ $saleContractPdfs->links() }}
                </div>
            </div>
        </div>     

        <div class="card display-card my-3 p-0">
            @if(optional($saleContract->inHouseInstallation)->actual_installation_report_pdf)
                <table class="en-list table table-borderless table-striped scrollbar">
                    <tbody>
                        <tr>
                            <th>Actual Installation Report Pdf</th>
                            <td>
                                <a href="{{ $saleContract->inHouseInstallation->actual_installation_report_pdf }}" target="_blank" class="btn btn-sm btn-primary rounded-pill"><i class="far fa-eye"></i> View</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>

        {{-- @include('admin.handOverPdfs.displayRecords') --}}
        @include('admin.handOverPdfs.handOverRecords')
        
    </div>
</div>
@endsection
