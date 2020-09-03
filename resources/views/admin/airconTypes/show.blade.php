@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.airconType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.aircon-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.airconType.fields.id') }}
                        </th>
                        <td>
                            {{ $airconType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.airconType.fields.type') }}
                        </th>
                        <td>
                            {{ $airconType->type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.airconType.fields.parent') }}
                        </th>
                        <td>
                            {{ $airconType->parent }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.aircon-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection