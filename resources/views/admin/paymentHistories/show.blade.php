@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.paymentHistory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payment-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentHistory.fields.id') }}
                        </th>
                        <td>
                            {{ $paymentHistory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentHistory.fields.sale_contract') }}
                        </th>
                        <td>
                            {{ $paymentHistory->sale_contract->has_installation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentHistory.fields.payment_step_from') }}
                        </th>
                        <td>
                            {{ $paymentHistory->payment_step_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentHistory.fields.payment_step_to') }}
                        </th>
                        <td>
                            {{ $paymentHistory->payment_step_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentHistory.fields.created_by') }}
                        </th>
                        <td>
                            {{ $paymentHistory->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentHistory.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $paymentHistory->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payment-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection