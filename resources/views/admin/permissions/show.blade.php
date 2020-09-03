@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.permission.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.id') }}
                        </th>
                        <td>
                            {{ $permission->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.title') }}
                        </th>
                        <td>
                            {{ $permission->title }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <a style="margin-top:20px;" class="btn btn-create" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>

        </div>

        {{-- <nav class="mb-3">
            <div class="nav nav-tabs">

            </div>
        </nav>
        <div class="tab-content">

        </div> --}}
    </div>
</div>
@endsection