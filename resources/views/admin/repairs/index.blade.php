@extends('layouts.admin')
@section('content')
{{-- @can('repair_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.repairs.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.repair.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}

<div style="margin-left: 30px;">
    <div class="d-flex">
        <form action="{{ route('admin.repairs.index') }}" method="GET">
            <div class="form-group align-items-center" style="display: flex;">
                <label for="team_type" class="mr-2" style="color: white;">Team Type</label>
                <select name="team_type" class="form-control" onchange="this.form.submit()" style="width:100px;">
                    <option value="all">All</option>
                    @foreach(App\Repair::TEAM_TYPE_SELECT as $key => $value)
                        <option value="{{ $key }}" {{ $key == request()->team_type ? 'selected' : ""}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card content-card display-card text-white">

    <div class="card-header">
        {{ trans('cruds.repair.title_singular') }} {{ trans('global.list') }}

    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>
                            Created At
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.oncall') }}
                        </th>
                        <th>{{ trans('cruds.repair.fields.status') }}</th>
                        <th>
                            {{ trans('cruds.repair.fields.estimate_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.actual_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.has_spare_part_replacement') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.service_report_pdf') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.updated_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.team_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $repairs->perPage())
                    @endphp
                    @foreach($repairs as $key => $repair)
                        <tr data-entry-id="{{ $repair->id }}">
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                {{ $repair->created_at->format('M-d-Y') ?? '' }}
                            </td>
                            <td>
                                {{ $repair->oncall->project->name ?? '' }}
                            </td>
                            <td>
                                {{ $repair->status ?? ''}}
                            </td>
                            <td>
                                {{ $repair->estimate_date ?? '' }}
                            </td>
                            <td>
                                {{ $repair->actual_date ?? '' }}
                            </td>
                            <td>
                                {{ App\Repair::HAS_SPARE_PART_REPLACEMENT_RADIO[$repair->has_spare_part_replacement] ?? '' }}
                            </td>
                            <td>
                                @if ( $repair->service_report_pdf )
                                    <a href="{{ $repair->service_report_pdf }}" class="btn btn-sm btn-create px-2" target="_blank">
                                        View PDF
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $repair->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $repair->updated_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $repair->type ?? '' }}
                            </td>
                            <td>
                                @can('repair_show')
                                    <a class="btn btn-sm btn-create px-2" href="{{ route('admin.repairs.show', $repair->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('repair_edit')
                                    {{-- <a class="btn btn-xs btn-info" href="{{ route('admin.repairs.edit', $repair->id) }}">
                                        {{ trans('global.edit') }}
                                    </a> --}}
                                @endcan

                                {{-- @can('repair_delete')
                                    <form action="{{ route('admin.repairs.destroy', $repair->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $repairs->appends(array_filter(request()->except('page')))->links() }}
        </div>

    </div>
</div>
@endsection