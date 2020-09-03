@extends('layouts.admin')
@section('content')
<div class="card content-card display-card text-white">
    <div class="card-header">
        Excel Exports
    </div>

    <div class="card-body">
        <form action="{{ route('admin.excel-exports') }}" method="GET">
            <div class="d-flex excel-export-options-container">
                <div class="excel-export-options-wrapper">
                    <div class="excel-export-options">
                        <select name='type' class="form-control" onchange="this.form.submit()">
                            @foreach($models as $key => $model)
                                <option value="{{ $key }}" {{ request()->type == $key ? 'selected' : ""}}>{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="excel-export-options">
                        <div class="excel-export-options">
                            <input type="text" name="from" class="form-control date" value="{{ request()->from }}" onblur="this.form.submit()">
                        </div>
                    </div>
                    <div class="excel-export-options">
                        <div class="excel-export-options">
                            <input type="text" name="to" class="form-control date" value="{{ request()->to ?? date(now()) }}" onblur="this.form.submit()">
                        </div>
                    </div>
                </div>
                <div class="excel-export-button">
                    {{-- <button type="submit" class="btn btn-success">Search</button> --}}
                    <button name='export' type=submit class="btn btn-create px-2"><i class="fas fa-file-export"></i> Export</button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            @if($type == 'enquiry')
                @include('admin.excelExports.enquiries')
            @elseif($type == 'quotation')
                @include('admin.excelExports.quotations')
            @else
                @include('admin.excelExports.saleContracts')
            @endif
        </div>
    </div>
</div>
@endsection