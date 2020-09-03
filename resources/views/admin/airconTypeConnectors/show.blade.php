@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.airconTypeConnector.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.aircon-type-connectors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.airconTypeConnector.fields.id') }}
                        </th>
                        <td>
                            {{ $airconTypeConnector->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.airconTypeConnector.fields.enquiries') }}
                        </th>
                        <td>
                            {{ $airconTypeConnector->enquiries->location ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.airconTypeConnector.fields.aircon_type') }}
                        </th>
                        <td>
                            @foreach($airconTypeConnector->aircon_types as $key => $aircon_type)
                                <span class="label label-info">{{ $aircon_type->type }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.aircon-type-connectors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection