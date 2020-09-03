@extends('layouts.admin')
@section('content')

@include('showErrors')
<div class="card">
    <div class="card-header">
        Fill actual action data
    </div>

    <div class="card-body">
        @include('admin.repairs.actualActionForm')
    </div>
</div>
@endsection