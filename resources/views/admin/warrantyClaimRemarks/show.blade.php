@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.warrantyClaimRemark.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.warranty-claim-remarks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimRemark.fields.id') }}
                        </th>
                        <td>
                            {{ $warrantyClaimRemark->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimRemark.fields.warranty_claim') }}
                        </th>
                        <td>
                            {{ $warrantyClaimRemark->warranty_claim->status ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.warrantyClaimRemark.fields.remark') }}
                        </th>
                        <td>
                            {!! $warrantyClaimRemark->remark !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.warranty-claim-remarks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection