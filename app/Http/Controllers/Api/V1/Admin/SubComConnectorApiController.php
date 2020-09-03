<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubComConnectorRequest;
use App\Http\Requests\UpdateSubComConnectorRequest;
use App\Http\Resources\Admin\SubComConnectorResource;
use App\SubComConnector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubComConnectorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_com_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubComConnectorResource(SubComConnector::with(['sub_com', 'sub_com_installation'])->get());
    }

    public function store(StoreSubComConnectorRequest $request)
    {
        $subComConnector = SubComConnector::create($request->all());

        return (new SubComConnectorResource($subComConnector))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SubComConnector $subComConnector)
    {
        abort_if(Gate::denies('sub_com_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubComConnectorResource($subComConnector->load(['sub_com', 'sub_com_installation']));
    }

    public function update(UpdateSubComConnectorRequest $request, SubComConnector $subComConnector)
    {
        $subComConnector->update($request->all());

        return (new SubComConnectorResource($subComConnector))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubComConnector $subComConnector)
    {
        abort_if(Gate::denies('sub_com_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComConnector->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
