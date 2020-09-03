@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.serviceType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceType.fields.id') }}
                        </th>
                        <td>
                            {{ $serviceType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceType.fields.type') }}
                        </th>
                        <td>
                            {{ $serviceType->type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group mt-3">
                <a class="btn btn-create" href="{{ route('admin.service-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection