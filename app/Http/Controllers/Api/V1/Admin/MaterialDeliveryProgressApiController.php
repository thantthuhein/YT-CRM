<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterialDeliveryProgressRequest;
use App\Http\Requests\UpdateMaterialDeliveryProgressRequest;
use App\Http\Resources\Admin\MaterialDeliveryProgressResource;
use App\MaterialDeliveryProgress;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaterialDeliveryProgressApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('material_delivery_progress_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MaterialDeliveryProgressResource(MaterialDeliveryProgress::with(['inhouse_installation', 'created_by', 'last_updated_by'])->get());
    }

    public function store(StoreMaterialDeliveryProgressRequest $request)
    {
        $materialDeliveryProgress = MaterialDeliveryProgress::create($request->all());

        return (new MaterialDeliveryProgressResource($materialDeliveryProgress))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MaterialDeliveryProgress $materialDeliveryProgress)
    {
        abort_if(Gate::denies('material_delivery_progress_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MaterialDeliveryProgressResource($materialDeliveryProgress->load(['inhouse_installation', 'created_by', 'last_updated_by']));
    }

    public function update(UpdateMaterialDeliveryProgressRequest $request, MaterialDeliveryProgress $materialDeliveryProgress)
    {
        $materialDeliveryProgress->update($request->all());

        return (new MaterialDeliveryProgressResource($materialDeliveryProgress))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MaterialDeliveryProgress $materialDeliveryProgress)
    {
        abort_if(Gate::denies('material_delivery_progress_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialDeliveryProgress->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
