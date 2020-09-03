@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subComInstallation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sub-com-installations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.id') }}
                        </th>
                        <td>
                            {{ $subComInstallation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.sale_contract') }}
                        </th>
                        <td>
                            {{ $subComInstallation->sale_contract->has_installation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.rating') }}
                        </th>
                        <td>
                            {{ $subComInstallation->rating }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.completed_month') }}
                        </th>
                        <td>
                            {{ $subComInstallation->completed_month }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.completed_year') }}
                        </th>
                        <td>
                            {{ $subComInstallation->completed_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subComInstallation.fields.installation_type') }}
                        </th>
                        <td>
                            {{ $subComInstallation->installation_type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sub-com-installations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection