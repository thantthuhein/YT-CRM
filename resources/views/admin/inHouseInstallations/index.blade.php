@extends('layouts.admin')
@section('content')

{{-- @can('in_house_installation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.in-house-installations.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.inHouseInstallation.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('cruds.inHouseInstallation.title_singular') }} {{ trans('global.list') }}
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
                            Customer Information
                        </th>
                        <th>
                            Team
                        </th>
                        <th>
                            Estimated Date
                        </th>
                        <th>
                            Actual Date
                        </th>
                        <th>
                            {{ trans('cruds.inHouseInstallation.fields.actual_installation_report_pdf') }}
                        </th>
                        <th>
                            Progress
                        </th>
                        <th>
                            {{ trans('cruds.inHouseInstallation.fields.tc_time') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                       $order = order(request()->page ?? 1, $inHouseInstallations->perPage())
                    @endphp
                    @foreach($inHouseInstallations as $key => $inHouseInstallation)
                        <tr data-entry-id="{{ $inHouseInstallation->id }}">
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                {{ $inHouseInstallation->created_at->format('M-d-Y') }}
                            </td>
                            <td>
                                {{ $inHouseInstallation->sale_contract->customer->name ?? '' }}
                                {{-- {{ $inHouseInstallation->sale_contract->morphableEnquiryQuotation }} --}}
                            </td>
                            <td>
                                {{ $inHouseInstallation->teams ?? '' }}
                            </td>
                            <td>
                                <span>from: {{ $inHouseInstallation->estimate_start_date ?? '' }}</span><br>
                                <span>to: {{ $inHouseInstallation->estimate_end_date ?? '' }}</span>
                            </td>
                            <td>
                                <span>from: {{ $inHouseInstallation->actual_start_date ?? '' }}</span><br>
                                <span>to: {{ $inHouseInstallation->actual_end_date ?? '' }}</span>
                            </td>
                            <td>
                                @if($inHouseInstallation->actual_installation_report_pdf)
                                    <a href="{{ $inHouseInstallation->actual_installation_report_pdf }}" target="_blank">
                                        View
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $inHouseInstallation->progress ?? 0 }}<br>
                                <div class="progress bg-dark" style="height: 10px; margin-bottom: 10px">

                                    @if ($inHouseInstallation->progress == 100)
                                        <div class="progress-bar bg-success"    
                                    @elseif ($inHouseInstallation->progress <= 99 && $inHouseInstallation->progress >= 70 )
                                        <div class="progress-bar bg-primary"
                                    @elseif ($inHouseInstallation->progress < 70 && $inHouseInstallation->progress >= 40)
                                        <div class="progress-bar bg-warning"
                                    @elseif ($inHouseInstallation->progress < 40 && $inHouseInstallation->progress >= 15)
                                        <div class="progress-bar bg-dark"
                                    @elseif ($inHouseInstallation->progress < 15)
                                        <div class="progress-bar bg-danger"
                                    @endif

                                    role="progressbar" style="color: black;width: {{ $inHouseInstallation->progress }}%;" value={{ $inHouseInstallation->progress }} aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $inHouseInstallation->tc_time ?? '' }}
                            </td>
                            <td>
                                @can('in_house_installation_show')
                                    <a class="btn btn-sm btn-create px-2" href="{{ route('admin.in-house-installations.show', $inHouseInstallation->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                {{-- @can('in_house_installation_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.in-house-installations.edit', $inHouseInstallation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('in_house_installation_delete')
                                    <form action="{{ route('admin.in-house-installations.destroy', $inHouseInstallation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        </div>
        {{ $inHouseInstallations->appends(array_filter(request()->except('page')))->links()}}


    </div>
</div>
@endsection