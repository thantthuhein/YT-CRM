@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.reminderTrash.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.reminder-trashes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.reminderTrash.fields.id') }}
                        </th>
                        <td>
                            {{ $reminderTrash->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.reminderTrash.fields.reminder') }}
                        </th>
                        <td>
                            {{ $reminderTrash->reminder->remindable ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.reminder-trashes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection