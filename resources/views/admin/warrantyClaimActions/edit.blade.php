@extends('layouts.admin')
@section('content')
    @include('admin.warrantyClaimActions.editForm', ['warrantyClaimAction' => $warrantyClaim->warranty_claim_action])
@endsection