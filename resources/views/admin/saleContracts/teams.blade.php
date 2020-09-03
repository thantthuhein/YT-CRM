@extends('layouts.admin')
@section('content')

<div class="card content-card" style="height: auto">
    <div class="card-header">
        Teams of Sale Contract {{ $saleContract->id }}
    </div>

    <div class="card-body">
        @include('admin.saleContracts.teamTabs')
    </div>
</div>

@endsection