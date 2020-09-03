<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRepairRemarkRequest;
use App\Http\Requests\StoreRepairRemarkRequest;
use App\Http\Requests\UpdateRepairRemarkRequest;
use App\Repair;
use App\RepairRemark;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepairRemarkController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('repair_remark_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairRemarks = RepairRemark::all();

        return view('admin.repairRemarks.index', compact('repairRemarks'));
    }

    public function create()
    {
        abort_if(Gate::denies('repair_remark_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairs = Repair::all()->pluck('estimate_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.repairRemarks.create', compact('repairs'));
    }

    public function store(StoreRepairRemarkRequest $request)
    {
        $repairRemark = RepairRemark::create($request->all());

        return redirect()->route('admin.repair-remarks.index');
    }

    public function edit(RepairRemark $repairRemark)
    {
        abort_if(Gate::denies('repair_remark_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairRemark->load('repair');

        return view('admin.repairRemarks.edit', compact('repairRemark'));
    }

    public function update(UpdateRepairRemarkRequest $request, RepairRemark $repairRemark)
    {
        $userId = auth()->user()->id;
        $repairRemark->update([
            'remark' => $request->remark,
            'updated_by_id' => $userId
        ]);

        return redirect()->route('admin.repairs.show', [$repairRemark->repair]);
    }

    public function show(RepairRemark $repairRemark)
    {
        abort_if(Gate::denies('repair_remark_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairRemark->load('repair');

        return view('admin.repairRemarks.show', compact('repairRemark'));
    }

    public function destroy(RepairRemark $repairRemark)
    {
        abort_if(Gate::denies('repair_remark_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairRemark->delete();

        return back();
    }

    public function massDestroy(MassDestroyRepairRemarkRequest $request)
    {
        RepairRemark::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
