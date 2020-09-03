@extends('layouts.admin')
@section('content')

<div class="card content-card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.followUp.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.follow-ups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.followUp.fields.id') }}
                        </th>
                        <td>
                            {{ $followUp->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.followUp.fields.quotation_revision') }}
                        </th>
                        <td>
                            {{ $followUp->quotation_revision->quotation_revision ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.followUp.fields.user') }}
                        </th>
                        <td>
                            {{ $followUp->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.followUp.fields.remark') }}
                        </th>
                        <td>
                            {!! $followUp->remark !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.followUp.fields.follow_up_time') }}
                        </th>
                        <td>
                            {{ $followUp->follow_up_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.followUp.fields.contact_person') }}
                        </th>
                        <td>
                            {{ $followUp->contact_person }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.followUp.fields.contact_number') }}
                        </th>
                        <td>
                            {{ $followUp->contact_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.followUp.fields.status') }}
                        </th>
                        <td>
                            {{ App\FollowUp::STATUS_RADIO[$followUp->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.follow-ups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection