<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRepairRemarkRequest;
use App\Http\Requests\UpdateRepairRemarkRequest;
use App\Http\Resources\Admin\RepairRemarkResource;
use App\RepairRemark;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepairRemarkApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('repair_remark_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairRemarkResource(RepairRemark::with(['repair'])->get());
    }

    public function store(StoreRepairRemarkRequest $request)
    {
        $repairRemark = RepairRemark::create($request->all());

        return (new RepairRemarkResource($repairRemark))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RepairRemark $repairRemark)
    {
        abort_if(Gate::denies('repair_remark_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairRemarkResource($repairRemark->load(['repair']));
    }

    public function update(UpdateRepairRemarkRequest $request, RepairRemark $repairRemark)
    {
        $repairRemark->update($request->all());

        return (new RepairRemarkResource($repairRemark))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RepairRemark $repairRemark)
    {
        abort_if(Gate::denies('repair_remark_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairRemark->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
