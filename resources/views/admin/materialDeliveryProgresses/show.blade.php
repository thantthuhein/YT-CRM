@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.materialDeliveryProgress.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.material-delivery-progresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.id') }}
                        </th>
                        <td>
                            {{ $materialDeliveryProgress->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.inhouse_installation') }}
                        </th>
                        <td>
                            {{ $materialDeliveryProgress->inhouse_installation->estimate_start_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.progress') }}
                        </th>
                        <td>
                            {{ $materialDeliveryProgress->progress }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.remark') }}
                        </th>
                        <td>
                            {!! $materialDeliveryProgress->remark !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.created_by') }}
                        </th>
                        <td>
                            {{ $materialDeliveryProgress->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.materialDeliveryProgress.fields.last_updated_by') }}
                        </th>
                        <td>
                            {{ $materialDeliveryProgress->last_updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.material-delivery-progresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection