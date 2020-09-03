@extends('layouts.admin')
@section('content')
@can('user_create')
    <div style="margin-left: 30px;" class="my-3">
        <a class="btn btn-create" href="{{ route("admin.users.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
        </a>
    </div>
@endcan
<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.phone_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $users->perPage())
                    @endphp
                    @foreach($users as $key => $user)
                        <tr>
                            <td>
                                {{$order++}}  
                            </td>
                            <td>
                                {{ $user->name ?? '' }}
                            </td>
                            <td>
                                {{ $user->email ?? '' }}
                            </td>
                            <td>
                                {{ $user->phone_number ?? '' }}
                            </td>
                            <td>
                                {{ $user->email_verified_at ?? '' }}
                            </td>
                            <td>
                                @foreach($user->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex">
                                    @can('user_show')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.users.show', $user->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
    
                                    @can('user_edit')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.users.edit', $user->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
    
                                    @can('user_delete')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-sm btn-create text-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $users->links() }}
            </div>
        </div>


    </div>
</div>
@endsection
