<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarrantyClaimRemarkRequest;
use App\Http\Requests\UpdateWarrantyClaimRemarkRequest;
use App\Http\Resources\Admin\WarrantyClaimRemarkResource;
use App\WarrantyClaimRemark;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarrantyClaimRemarkApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('warranty_claim_remark_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyClaimRemarkResource(WarrantyClaimRemark::with(['warranty_claim'])->get());
    }

    public function store(StoreWarrantyClaimRemarkRequest $request)
    {
        $warrantyClaimRemark = WarrantyClaimRemark::create($request->all());

        return (new WarrantyClaimRemarkResource($warrantyClaimRemark))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WarrantyClaimRemark $warrantyClaimRemark)
    {
        abort_if(Gate::denies('warranty_claim_remark_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyClaimRemarkResource($warrantyClaimRemark->load(['warranty_claim']));
    }

    public function update(UpdateWarrantyClaimRemarkRequest $request, WarrantyClaimRemark $warrantyClaimRemark)
    {
        $warrantyClaimRemark->update($request->all());

        return (new WarrantyClaimRemarkResource($warrantyClaimRemark))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WarrantyClaimRemark $warrantyClaimRemark)
    {
        abort_if(Gate::denies('warranty_claim_remark_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimRemark->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
