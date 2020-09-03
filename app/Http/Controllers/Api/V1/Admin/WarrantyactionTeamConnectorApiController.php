<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarrantyactionTeamConnectorRequest;
use App\Http\Requests\UpdateWarrantyactionTeamConnectorRequest;
use App\Http\Resources\Admin\WarrantyactionTeamConnectorResource;
use App\WarrantyactionTeamConnector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarrantyactionTeamConnectorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('warrantyaction_team_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyactionTeamConnectorResource(WarrantyactionTeamConnector::with(['warranty_action', 'servicing_team'])->get());
    }

    public function store(StoreWarrantyactionTeamConnectorRequest $request)
    {
        $warrantyactionTeamConnector = WarrantyactionTeamConnector::create($request->all());

        return (new WarrantyactionTeamConnectorResource($warrantyactionTeamConnector))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WarrantyactionTeamConnector $warrantyactionTeamConnector)
    {
        abort_if(Gate::denies('warrantyaction_team_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyactionTeamConnectorResource($warrantyactionTeamConnector->load(['warranty_action', 'servicing_team']));
    }

    public function update(UpdateWarrantyactionTeamConnectorRequest $request, WarrantyactionTeamConnector $warrantyactionTeamConnector)
    {
        $warrantyactionTeamConnector->update($request->all());

        return (new WarrantyactionTeamConnectorResource($warrantyactionTeamConnector))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WarrantyactionTeamConnector $warrantyactionTeamConnector)
    {
        abort_if(Gate::denies('warrantyaction_team_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyactionTeamConnector->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
