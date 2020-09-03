@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.installationProgress.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.installation-progresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.installationProgress.fields.id') }}
                        </th>
                        <td>
                            {{ $installationProgress->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.installationProgress.fields.inhouse_installation') }}
                        </th>
                        <td>
                            {{ $installationProgress->inhouse_installation->estimate_start_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.installationProgress.fields.progress') }}
                        </th>
                        <td>
                            {{ $installationProgress->progress }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.installationProgress.fields.remark') }}
                        </th>
                        <td>
                            {!! $installationProgress->remark !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.installationProgress.fields.created_by') }}
                        </th>
                        <td>
                            {{ $installationProgress->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.installationProgress.fields.latest_updated_by') }}
                        </th>
                        <td>
                            {{ $installationProgress->latest_updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.installation-progresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection