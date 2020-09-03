@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subComConnector.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sub-com-connectors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subComConnector.fields.id') }}
                        </th>
                        <td>
                            {{ $subComConnector->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subComConnector.fields.sub_com') }}
                        </th>
                        <td>
                            {{ $subComConnector->sub_com->company_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subComConnector.fields.sub_com_installation') }}
                        </th>
                        <td>
                            {{ $subComConnector->sub_com_installation->rating ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sub-com-connectors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection