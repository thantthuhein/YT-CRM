{{-- @can('repair_remark_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.repair-remarks.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.repairRemark.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
{{-- <div class="card mb-3">
    <div class="card-header">
        {{ trans('cruds.repairRemark.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body"> --}}
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-RepairRemark">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.repairRemark.fields.id') }}
                        </th>
                        <th>
                            Remark
                        </th>
                        <th>
                            Created By
                        </th>
                        <th>
                            Last Updated by
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repair->repairRemarks as $key => $repairRemark)
                        <tr data-entry-id="{{ $repairRemark->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $repairRemark->id ?? '' }}
                            </td>
                            <td>
                                {{ $repairRemark->remark ?? '' }}
                            </td>
                            <td>
                                {{ $repairRemark->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $repairRemark->updated_by->name ?? '' }}
                            </td>
                            <td>
                                @can('repair_remark_edit')
                                    <a class="btn btn-default rounded-pill" href="{{ route('admin.repair-remarks.edit', $repairRemark->id) }}">
                                        <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                {{-- @can('repair_remark_delete')
                                    <form action="{{ route('admin.repair-remarks.destroy', $repairRemark->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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


    {{-- </div>
</div> --}}