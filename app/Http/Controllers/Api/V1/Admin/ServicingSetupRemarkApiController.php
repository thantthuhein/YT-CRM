<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicingSetupRemarkRequest;
use App\Http\Requests\UpdateServicingSetupRemarkRequest;
use App\Http\Resources\Admin\ServicingSetupRemarkResource;
use App\ServicingSetupRemark;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingSetupRemarkApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_setup_remark_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingSetupRemarkResource(ServicingSetupRemark::with(['servicing_setup'])->get());
    }

    public function store(StoreServicingSetupRemarkRequest $request)
    {
        $servicingSetupRemark = ServicingSetupRemark::create($request->all());

        return (new ServicingSetupRemarkResource($servicingSetupRemark))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServicingSetupRemark $servicingSetupRemark)
    {
        abort_if(Gate::denies('servicing_setup_remark_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingSetupRemarkResource($servicingSetupRemark->load(['servicing_setup']));
    }

    public function update(UpdateServicingSetupRemarkRequest $request, ServicingSetupRemark $servicingSetupRemark)
    {
        $servicingSetupRemark->update($request->all());

        return (new ServicingSetupRemarkResource($servicingSetupRemark))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServicingSetupRemark $servicingSetupRemark)
    {
        abort_if(Gate::denies('servicing_setup_remark_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingSetupRemark->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
