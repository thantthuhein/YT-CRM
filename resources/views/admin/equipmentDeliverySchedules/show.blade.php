@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.equipmentDeliverySchedule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.equipment-delivery-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.equipmentDeliverySchedule.fields.id') }}
                        </th>
                        <td>
                            {{ $equipmentDeliverySchedule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.equipmentDeliverySchedule.fields.sale_contract') }}
                        </th>
                        <td>
                            {{ $equipmentDeliverySchedule->sale_contract->has_installation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.equipmentDeliverySchedule.fields.description') }}
                        </th>
                        <td>
                            {!! $equipmentDeliverySchedule->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.equipmentDeliverySchedule.fields.delivered_at') }}
                        </th>
                        <td>
                            {{ $equipmentDeliverySchedule->delivered_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.equipmentDeliverySchedule.fields.created_by') }}
                        </th>
                        <td>
                            {{ $equipmentDeliverySchedule->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.equipmentDeliverySchedule.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $equipmentDeliverySchedule->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.equipment-delivery-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection