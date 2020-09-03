@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.warrantyClaimValidation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.warranty-claim-validations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimValidation.fields.id') }}
                        </th>
                        <td>
                            {{ $warrantyClaimValidation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimValidation.fields.repair_team') }}
                        </th>
                        <td>
                            {{ $warrantyClaimValidation->repair_team->leader_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimValidation.fields.actual_date') }}
                        </th>
                        <td>
                            {{ $warrantyClaimValidation->actual_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimValidation.fields.created_by') }}
                        </th>
                        <td>
                            {{ $warrantyClaimValidation->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimValidation.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $warrantyClaimValidation->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.warranty-claim-validations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection