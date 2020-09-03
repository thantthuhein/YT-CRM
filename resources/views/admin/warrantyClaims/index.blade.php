@extends('layouts.admin')
@section('styles')
<style>
    .rejected{
        color: red;
    }
    .accepted{
        color: #38c172;
    }
</style>
    
@endsection
@section('content')

<div class="card display-card content-card text-white">
    <div class="card-header">
        {{ trans('cruds.warrantyClaim.title_singular') }} {{ trans('global.list') }}
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
                            Actual Date
                        </th>
                        <th>
                            Customer Name
                        </th>
                        <th>
                            Daikin rep name
                        </th>
                        <th>
                            PDF
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Created By
                        </th>
                        <th>
                            {{ trans('cruds.warrantyClaim.fields.updated_by') }}
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $warrantyClaims->perPage())
                    @endphp
                    @foreach($warrantyClaims as $key => $warrantyClaim)
                        <tr data-entry-id="{{ $warrantyClaim->id }}">
                            <td>
                                {{ $order++ }}
                            </td>
                            <td>
                                {{ $warrantyClaim->created_at->format('M-d-Y') ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaim->warranty_claim_validation->actual_date ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaim->oncall->customer->name ?? ''}}
                            </td>
                            <td>
                                {{ $warrantyClaim->warranty_claim_action->daikin_rep_name ?? '' }}
                            </td>
                            <td>
                                @if($warrantyClaim->warranty_claim_pdf)
                                    <a href="{{ $warrantyClaim->warranty_claim_pdf }}" target="_blank">
                                        {{ trans('global.view_file') }} <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="{{ $warrantyClaim->status }}">
                                {{ App\WarrantyClaim::STATUS_SELECT[$warrantyClaim->status] ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaim->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $warrantyClaim->updated_by->name ?? '' }}
                                
                                {{-- @can('warranty_claim_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.warranty-claims.edit', $warrantyClaim->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan --}}

                                {{-- @can('warranty_claim_delete')
                                    <form action="{{ route('admin.warranty-claims.destroy', $warrantyClaim->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan --}}

                            </td>
                            <td>
                                @can('warranty_claim_show')
                                    <a class="btn btn-sm px-2 btn-create" href="{{ route('admin.warranty-claims.show', $warrantyClaim->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $warrantyClaims->appends(array_filter(request()->except('page')))->links()}}


    </div>
</div>
@endsection