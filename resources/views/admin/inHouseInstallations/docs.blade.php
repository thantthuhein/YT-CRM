@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">

    <div class="card-header">
        Other Documents for Service Manager
    </div>

    <div class="card-body">

        @if($saleContract->has_installation)
            @include('admin.inHouseInstallations.otherDocsForServiceManager')
        @endif

        @include('admin.handOverPdfs.displayRecords')
    </div>
</div>
@endsection