@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.onCall.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">

            <div class="my-3">
                @if ( ! $onCall->warrantyClaims->isEmpty() )
                    <a href="{{ route('admin.warranty-claims.show', optional($onCall->warrantyClaims->first())->id) }}" class="btn btn-create">Go to Warranty claims Setting</a>
                @endif
                @if ( ! $onCall->repairs->isEmpty() )
                    <a href="{{ route('admin.repairs.show', optional($onCall->repairs->first())->id) }}" class="btn btn-create">Go to Repair Setting</a>
                @endif
                @if ( ! $onCall->servicingSetups->isEmpty() )
                    <a href="{{ route('admin.servicing-setups.show', $onCall->servicingSetups->first() ) }}" class="btn btn-create">Go to Servicing Setup</a>
                @endif
            </div>
            
            <table class="en-list table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.onCall.fields.project') }}
                        </th>
                        <td>
                            {{ $onCall->project->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onCall.fields.service_type') }}
                        </th>
                        <td>
                            {{ $onCall->service_type->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onCall.fields.remark') }}
                        </th>
                        <td>
                            {!! $onCall->remark !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onCall.fields.customer') }}
                        </th>
                        <td>
                            {{ $onCall->customer->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onCall.fields.created_by') }}
                        </th>
                        <td>
                            {{ $onCall->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onCall.fields.status') }}
                        </th>
                        <td>
                            {{ $onCall->status ?? '' }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.onCall.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $onCall->updated_by->name ?? '' }}
                        </td>
                    </tr> --}}
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-create btn-sm px-3" href="{{ route('admin.on-calls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection