@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.userBranchConnector.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-branch-connectors.update", [$userBranchConnector->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.userBranchConnector.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ ($userBranchConnector->user ? $userBranchConnector->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <span class="text-danger">{{ $errors->first('user_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.userBranchConnector.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_id">{{ trans('cruds.userBranchConnector.fields.branch') }}</label>
                <select class="form-control select2 {{ $errors->has('branch') ? 'is-invalid' : '' }}" name="branch_id" id="branch_id">
                    @foreach($branches as $id => $branch)
                        <option value="{{ $id }}" {{ ($userBranchConnector->branch ? $userBranchConnector->branch->id : old('branch_id')) == $id ? 'selected' : '' }}>{{ $branch }}</option>
                    @endforeach
                </select>
                @if($errors->has('branch_id'))
                    <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.userBranchConnector.fields.branch_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection