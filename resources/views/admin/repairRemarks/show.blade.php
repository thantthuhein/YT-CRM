@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.repairRemark.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.repair-remarks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.repairRemark.fields.id') }}
                        </th>
                        <td>
                            {{ $repairRemark->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairRemark.fields.repair') }}
                        </th>
                        <td>
                            {{ $repairRemark->repair->estimate_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repairRemark.fields.remark') }}
                        </th>
                        <td>
                            {!! $repairRemark->remark !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.repair-remarks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection